<?php

namespace PHPShopify;

class GuzzleAdapter implements HttpClient
{
    /**
     * Guzzle client instance
     */
    protected $client;

    protected $lastResponse;

    /**
     * Pass guzzle http client in constructor
     *
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param $url
     * @param $headers
     *
     * @return string
     */
    public function get($url, $headers = array())
    {
        $this->lastResponse = $this->client->get($url, [
            'headers' => $headers,
        ]);

        return $this->getContents();
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
        $options = [
            'headers' => $headers,
        ];

        if (!empty($data)) {
            $options['json'] = $data;
        }

        $this->lastResponse = $this->client->post($url, $options);

        return $this->getContents();
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
        $options = [
            'headers' => $headers,
        ];

        if (!empty($data)) {
            $options['json'] = $data;
        }

        $this->lastResponse = $this->client->put($url, $options);

        return $this->getContents();
    }

    /**
     * @param $url
     * @param $headers
     *
     * @return string
     */
    public function delete($url, $headers = array())
    {
        $this->lastResponse = $this->client->delete($url, [
            'headers' => $headers,
        ]);

        return $this->getContents();
    }

    /**
     * @return mixed
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @return int
     */
    public function getLastResponseCode()
    {
        if (empty($this->lastResponse)) {
            return 0;
        }

        return $this->lastResponse->getStatusCode();
    }

    /**
     * @return array
     */
    public function getLastResponseHeaders()
    {
        if (empty($this->lastResponse)) {
            return array();
        }

        $result = array();

        foreach ($this->lastResponse->getHeaders() as $name => $value) {
            $result[strtolower($name)] = $value[0];
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function getContents()
    {
        $contents = '';
        $body = $this->lastResponse->getBody();

        if ($body) {
            $contents = $body->getContents();
            $body->rewind();
        }

        return $contents;
    }
}