<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 8/24/16 9:03 AM UTC+06:00
 */

namespace PHPShopify;

class HttpRequestJson extends CurlRequest
{
    protected static function init(string $method, string $url, array $httpHeaders = [], $data = null)
    {
        // Note: Is null valid for any shopify calls?
        if ($data !== null) {
            $httpHeaders['Content-type'] = 'application/json';
            $data = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return parent::init($method, $url, $httpHeaders, $data);
    }

    protected static function parseBody(string $body)
    {
        return json_decode($body, true);
    }
}