<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/17/16 2:50 PM UTC+06:00
 */

namespace PHPShopify;


use PHPShopify\Exception\CurlException;

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

        $output = curl_exec($ch);

        if(isset($headers['x-shopify-shop-api-call-limit'])){
            list($currentState,$limit) = explode('/',$headers['x-shopify-shop-api-call-limit'][0]);
            if($currentState >= $limit-3){
                //var_dump($currentState.' sleeping for 1s');
                sleep(1);
            }
        }

        if (curl_errno($ch)) {
            throw new Exception\CurlException(curl_errno($ch) . ' : ' . curl_error($ch));
        }

        self::$lastHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close curl resource to free up system resources
        curl_close($ch);

        return $output;
    }
}