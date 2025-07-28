<?php

namespace PHPShopify;

interface HttpClient
{
    /**
     * @param string $url
     * @param array $headers
     *
     * @return string
     */
    public function get ($url, $headers = array());

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function post($url, $data = array(), $headers = array());

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function put($url, $data = array(), $headers = array());

    /**
     * @param string $url
     * @param array $headers
     *
     * @return string
     */
    public function delete ($url, $headers = array());

    /**
     * @return int
     */
    public function getLastResponseCode();

    /**
     * @return array
     */
    public function getLastResponseHeaders();
}