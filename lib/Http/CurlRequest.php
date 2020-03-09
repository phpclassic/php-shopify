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
     * This allows use of keepalive.
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
            curl_setopt(self::$ch, CURLOPT_USERAGENT, 'PHPClassic/PHPShopify');
        }
vaR_dump($url);
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

            if (isset($limitHeader[1]) && $limitHeader[0] < $limitHeader[1]) {
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
