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
     * URL of the last executed request
     *
     * @var string
     */
    public static $lastRequestUrl;

    /**
     * Payload of the last executed request
     *
     * @var string
     */
    public static $lastRequestData = null;

    /**
     * Headers of the last executed request
     *
     * @var string
     */
    public static $lastRequestHeaders = null;

    /**
     * Headers of the last returned response
     *
     * @var string
     */
    public static $lastResponseHeaders = null;

    /**
     * Body of the last returned response
     *
     * @var string
     */
    public static $lastResponseBody = null;

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

        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $headers = array();
        foreach ($httpHeaders as $key => $value) {
            $headers[] = "$key: $value";
        }
        //Set HTTP Headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        self::$lastRequestUrl = $url;

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

        self::$lastRequestData = null;

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

        self::$lastRequestData = $data;

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

        self::$lastRequestData = $data;

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

        self::$lastRequestData = null;

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
        $headers = [];
        // $output contains the output string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers)
            {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $name = strtolower(trim($header[0]));
                if (!array_key_exists($name, $headers))
                    $headers[$name] = [trim($header[1])];
                else
                    $headers[$name][] = trim($header[1]);

                return $len;
            }
        );

        # Check for 429 leaky bucket error
        while (1) {
            $output   = curl_exec($ch);
            $response = new CurlResponse($output);

            self::$lastHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (self::$lastHttpCode != 429) {
                self::$lastRequestHeaders = curl_getinfo($ch, CURLINFO_HEADER_OUT);
                self::$lastResponseHeaders = json_encode($headers);
                self::$lastResponseBody = $output;
                break;
            }

            $limitHeader = explode('/', $response->getHeader('X-Shopify-Shop-Api-Call-Limit'), 2);

            if (isset($limitHeader[1]) && $limitHeader[0] < $limitHeader[1]) {
                throw new ResourceRateLimitException($response->getBody());
            }

            usleep(500000);
        }

        if (curl_errno($ch)) {
            $lastCallData = [
                'request_url' => self::$lastRequestUrl,
                'request_headers' => self::$lastRequestHeaders,
                'request_data' => self::$lastRequestData,
                'response_headers' => self::$lastResponseHeaders,
                'response_body' => self::$lastResponseBody
            ];

            throw new Exception\CurlException(addslashes(curl_errno($ch) . ' : ' . curl_error($ch)), $lastCallData, self::$lastHttpCode);
        }

        // close curl resource to free up system resources
        curl_close($ch);

        return $response->getBody();
    }

}
