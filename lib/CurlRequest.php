<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/17/16 2:50 PM UTC+06:00
 */

namespace PHPShopify;


use PHPShopify\Exception\CurlException;
use PHPShopify\Exception\ResourceRateLimitException;

/*
|--------------------------------------------------------------------------
| CurlRequest
|--------------------------------------------------------------------------
|
| This class handles get, post, put, delete HTTP requests
|
*/
class CurlRequest
{
    /**
     * HTTP Code of the last executed request
     *
     * @var integer
     */
    public static $lastHttpCode;

    /**
     * HTTP response headers of last executed request
     *
     * @var array
     */
    public static $lastHttpResponseHeaders = array();

    /**
     * Initialize the curl resource
     *
     * @param string $url
     * @param array $httpHeaders
     *
     * @return resource
     */
    protected static function init($url, $httpHeaders = array())
    {
        // Create Curl resource
        $ch = curl_init();

        // Set URL
        curl_setopt($ch, CURLOPT_URL, $url);

        //Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHPClassic/PHPShopify');

        $headers = array();
        foreach ($httpHeaders as $key => $value) {
            $headers[] = "$key: $value";
        }
        //Set HTTP Headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return $ch;

    }

    /**
     * Implement a GET request and return output
     *
     * @param string $url
     * @param array $httpHeaders
     *
     * @return string
     */
    public static function get($url, $httpHeaders = array())
    {
        //Initialize the Curl resource
        $ch = self::init($url, $httpHeaders);

        return self::processRequest($ch);
    }

    /**
     * Implement a POST request and return output
     *
     * @param string $url
     * @param array $data
     * @param array $httpHeaders
     *
     * @return string
     */
    public static function post($url, $data, $httpHeaders = array())
    {
        $ch = self::init($url, $httpHeaders);
        //Set the request type
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        return self::processRequest($ch);
    }

    /**
     * Implement a PUT request and return output
     *
     * @param string $url
     * @param array $data
     * @param array $httpHeaders
     *
     * @return string
     */
    public static function put($url, $data, $httpHeaders = array())
    {
        $ch = self::init($url, $httpHeaders);
        //set the request type
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        return self::processRequest($ch);
    }

    /**
     * Implement a DELETE request and return output
     *
     * @param string $url
     * @param array $httpHeaders
     *
     * @return string
     */
    public static function delete($url, $httpHeaders = array())
    {
        $ch = self::init($url, $httpHeaders);
        //set the request type
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        return self::processRequest($ch);
    }

    /**
     * Execute a request, release the resource and return output
     *
     * @param resource $ch
     *
     * @throws CurlException if curl request is failed with error
     *
     * @return string
     */
    protected static function processRequest($ch)
    {
        # Check for 429 leaky bucket error
        while (1) {
            $output   = curl_exec($ch);
            $response = new CurlResponse($output);

            self::$lastHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (self::$lastHttpCode != 429) {
                break;
            }

            $limitHeader = explode('/', $response->getHeader('X-Shopify-Shop-Api-Call-Limit'), 2);

            if (isset($limitHeader[1]) && $limitHeader[0] < $limitHeader[1]) {
                throw new ResourceRateLimitException($response->getBody());
            }

            $retryAfter = $response->getHeader('Retry-After');

            if ($retryAfter === null) {
                break;
            }

            sleep((float)$retryAfter);
        }

        if (curl_errno($ch)) {
            throw new Exception\CurlException(curl_errno($ch) . ' : ' . curl_error($ch));
        }

        // close curl resource to free up system resources
        curl_close($ch);

        self::$lastHttpResponseHeaders = $response->getHeaders();

        return $response->getBody();
    }

}
