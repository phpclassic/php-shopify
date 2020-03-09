<?php

namespace PHPShopify\Http;

use PHPShopify\Exception\CurlException;
use PHPShopify\Exception\ResourceRateLimitException;

class CurlRequest {
    /**
     * The time wait before retrying when the request was rate limited in microseconds.
     */
    const RATE_LIMIT_RETRY_DELAY = 500000;

    /**
     * Number of times to retry on rate limit.
     */
    const RATE_LIMIT_RETRIES = 10;
    /**
     * Amount of time to retry for (not exact) in seconds.
     */
    const RATE_LIMIT_TIMEOUT = 10;

    /**
     * Response timeout in seconds.
     */
    const TIMEOUT = 10;
    /**
     * Connect timeout in seconds.
     */
    const CONNECT_TIMEOUT = 5;

    /**
     * This allows use of keepalive.
     *
     * There is some risk in this that settings might carry over
     * @var resource
     */
    protected static $ch;

    /**
     * @inheritDoc
     * @param string|string[]|null $data
     * @return resource
     */
    protected function init(string $method, string $url, array $httpHeaders = [], $data = null) {
        if (self::$ch === null) {
            self::$ch = curl_init();

            curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt(self::$ch, CURLOPT_HEADER, true);
            curl_setopt(self::$ch, CURLOPT_USERAGENT, 'PHPClassic/PHPShopify (v2)');
            curl_setopt(self::$ch, CURLOPT_TIMEOUT, static::TIMEOUT);
            curl_setopt(self::$ch, CURLOPT_CONNECTTIMEOUT, static::CONNECT_TIMEOUT);
            curl_setopt(self::$ch, CURLOPT_ENCODING, 'gzip,deflate');
        }

        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt(self::$ch, CURLOPT_URL, $url);

        if ($data !== null && !is_string($data)) {
            $data = static::serializeData($data);
        }

        curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $data);
        $headers = [];

        foreach ($httpHeaders as $key => $value) {
            $headers[] = "{$key}: {$value}";
        }

        curl_setopt(self::$ch, CURLOPT_HTTPHEADER, $headers);

        return self::$ch;
    }

    public function destroy(): void {
        if (self::$ch !== null) {
            $ch = self::$ch;
            self::$ch = null;
            curl_close($ch);
        }
    }

    public function get(string $url, array $httpHeaders = []): CurlResponse {
        return static::processRequest(static::init('GET', $url, $httpHeaders));
    }

    /**
     * @inheritDoc
     * @param string|array $data
     */
    public function post(string $url, $data, array $httpHeaders = []): CurlResponse {
        return static::processRequest(static::init('POST', $url, $httpHeaders, $data));
    }

    public function put($url, $data, array $httpHeaders = []): CurlResponse {
        return static::processRequest(static::init('PUT', $url, $httpHeaders, $data));
    }

    public function delete(string $url, array $httpHeaders = []): CurlResponse {
        return static::processRequest(static::init('DELETE', $url, $httpHeaders));
    }

    /**
     * @inheritDoc
     * @param resource $ch
     * @throws CurlException if curl request is failed with error
     */
    protected function processRequest($ch): CurlResponse {
        $start = microtime(true);
        $tries = 0;
        # Check for 429 leaky bucket error
        while (true) {
            $output = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new CurlException(curl_errno($ch) . ' : ' . curl_error($ch));
            }

            assert(is_string($output));

            $parsedResponse = static::parseResponse($output);
            // Note: Missing error handling here.
            $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $response = new CurlResponse($status, $parsedResponse['headers'], $parsedResponse['body']);

            if ($response->getStatus() != 429) {
                break;
            }

            $limitHeader = explode('/', $response->getHeader('X-Shopify-Shop-Api-Call-Limit'), 2);
            $tries++;
            $took = (microtime(true) - $start) + (static::RATE_LIMIT_RETRY_DELAY / 1000000);

            /**
             * This makes no sense. It can likely ignore this header and use Retry-After if set otherwise throw an
             * exception.
             */
            if ((isset($limitHeader[1]) && $limitHeader[0] < $limitHeader[1]) ||
                $tries > static::RATE_LIMIT_RETRIES || $took > static::RATE_LIMIT_TIMEOUT) {
                throw new ResourceRateLimitException($response->getBody());
            }

            usleep(static::RATE_LIMIT_RETRY_DELAY);
        }

        return $response;
    }

    protected function parseResponse(string $response): array {
        $response = explode("\r\n\r\n", $response, 2);

        assert(count($response) === 2);
        $headers = [];
        [$headerString, $bodyString] = $response;

        foreach (explode("\r\n", $headerString) as $header) {
            $pair = explode(': ', $header, 2);
            [$key, $value] = $pair + [1 => null];
            $key = strtolower($key);

            if (!array_key_exists($key, $headers)) {
                $headers[$key] = [];
            }

            $headers[$key][] = $value;
        }

        $body = static::parseBody($bodyString);

        return compact('headers', 'body');
    }

    protected function serializeData($data): string {
        return http_build_query($data);
    }

    protected function parseBody(string $body) {
        return $body;
    }
}
