<?php

namespace PHPShopify\Http;

class HttpRequestJson extends CurlRequest {
    protected static function init(string $method, string $url, array $httpHeaders = [], $data = null) {
        // Note: Is null valid for any shopify calls?
        if ($data !== null) {
            $httpHeaders['Content-type'] = 'application/json';
        }

        return parent::init($method, $url, $httpHeaders, $data);
    }

    protected static function parseBody(string $body) {
        return json_decode($body, true);
    }

    public static function serializeData($data): string {
        return self::encode($data);
    }

    public static function encode($data): string {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
