<?php
/**
 * Created by PhpStorm.
 * User: Tareq
 * Date: 5/30/2019
 * Time: 3:25 PM
 */

namespace PHPShopify;


use PHPShopify\Exception\SdkException;

class HttpRequestGraphQL extends HttpRequestJson
{
    /**
     * Prepared GraphQL string to be posted with request
     *
     * @var string
     */
    private static $postDataGraphQL;

    /**
     * Prepare the data and request headers before making the call
     *
     * @param mixed $data
     * @param array $httpHeaders
     *
     * @return void
     *
     * @throws SdkException if $data is not a string
     */
    protected static function prepareRequest($httpHeaders = array(), $data = array())
    {

        if (is_string($data)) {
            self::$postDataGraphQL = $data;
        } else {
            throw new SdkException("Only GraphQL string is allowed!");
        }

        if (!isset($httpHeaders['X-Shopify-Access-Token'])) {
            throw new SdkException("The GraphQL Admin API requires an access token for making authenticated requests!");
        }

        self::$httpHeaders = $httpHeaders;
        self::$httpHeaders['Content-type'] = 'application/graphql';

    }

    /**
     * Implement a POST request and return json decoded output
     *
     * @param string $url
     * @param mixed $data
     * @param array $httpHeaders
     *
     * @return string
     */
    public static function post($url, $data, $httpHeaders = array())
    {
        self::prepareRequest($httpHeaders, $data);

        $response = CurlRequest::post($url, self::$postDataGraphQL, self::$httpHeaders);

        return self::processResponse($response);
    }
}