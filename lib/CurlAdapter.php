<?php

namespace PHPShopify;

class CurlAdapter implements HttpClient
{
    /**
     * @param $url
     * @param $headers
     *
     * @return string
     */
    public function get($url, $headers = array())
    {
        return CurlRequest::get($url, $headers);
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function post($url, $data = array(), $headers = array())
    {
        return CurlRequest::post($url, json_encode($data), $headers);
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function put($url, $data = array(), $headers = array())
    {
        return CurlRequest::put($url, json_encode($data), $headers);
    }

    /**
     * @param $url
     * @param $headers
     *
     * @return string
     */
    public function delete($url, $headers = array())
    {
        return CurlRequest::delete($url, $headers);
    }

    /**
     * @return int
     */
    public function getLastResponseCode()
    {
        return CurlRequest::$lastHttpCode;
    }

    /**
     * @return array
     */
    public function getLastResponseHeaders()
    {
        return CurlRequest::$lastHttpResponseHeaders;
    }
}