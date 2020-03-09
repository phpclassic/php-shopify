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
    private static $ch;

    /**
     * @inheritDoc
     * @param string|string[]|null $data
     * @return resource
     */
    protected static function init(string $method, string $url, array $httpHeaders = [], $data = null) {
        if (self::$ch === null) {
            self::$ch = curl_init();

            curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt(self::$ch, CURLOPT_HEADER, true);
            curl_setopt(self::$ch, CURLOPT_USERAGENT, 'PHPClassic/PHPShopify');
        }

        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt(self::$ch, CURLOPT_URL, $url);

        if ($data !== null) {
            $headers['Content-Length'] = strlen($data);
            curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $data);
        }

        $headers = [];

        foreach ($httpHeaders as $key => $value) {
            $headers[] = "{$key}: {$value}";
        }

        curl_setopt(self::$ch, CURLOPT_HTTPHEADER, $headers);

        return self::$ch;
    }

    public static function destroy(): void {
        if (self::$ch !== null) {
            $ch = self::$ch;
            self::$ch = null;
            curl_close($ch);
        }
    }

    public static function get(string $url, array $httpHeaders = []): CurlResponse {
        return self::processRequest(self::init('GET', $url, $httpHeaders));
    }

    /**
     * @inheritDoc
     * @param string|array $data
     */
    public static function post(string $url, $data, array $httpHeaders = []): CurlResponse {
        return self::processRequest(self::init('POST', $url, $httpHeaders, $data));
    }

    public static function put($url, $data, array $httpHeaders = []): CurlResponse {
        return self::processRequest(self::init('PUT', $url, $httpHeaders, $data));
    }

    public static function delete(string $url, array $httpHeaders = []): CurlResponse {
        return self::processRequest(self::init('DELETE', $url, $httpHeaders));
    }

    /**
     * @inheritDoc
     * @param resource $ch
     * @throws CurlException if curl request is failed with error
     */
    protected static function processRequest($ch): CurlResponse {
        # Check for 429 leaky bucket error
        while (true) {
            $output = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new CurlException(curl_errno($ch) . ' : ' . curl_error($ch));
            }

            assert(is_string($output));

            $parsedResponse = self::parseResponse($output);
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

            usleep(self::RATE_LIMIT_RETRY_DELAY);
        }

        return $response;
    }

    private static function parseResponse(string $response): array {
        $response = explode("\r\n\r\n", $response, 2);
        $headers = [];

        assert(count($response) === 2);
        [$headers, $body] = $response;

        foreach (explode("\r\n", $headers) as $header) {
            $pair = explode(': ', $header, 2);

            if (isset($pair[1])) {
                $headerKey = strtolower($pair[0]);
                $headers[$headerKey] = $pair[1];
            }
        }

        // Gimme yur body.
        $body = self::parseBody($body);

        return compact('headers', 'body');
    }

    protected static function parseBody(string $body) {
        return $body;
    }
}
