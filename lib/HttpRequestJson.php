<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 8/24/16 9:03 AM UTC+06:00
 */

namespace PHPShopify;

/**
 * Class HttpRequestJson
 *
 * Prepare the data / headers for JSON requests, make the call and decode the response
 * Accepts data in array format returns data in array format
 *
 * @uses CurlRequest
 *
 * @package PHPShopify
 */
class HttpRequestJson
{
    /**
     * HTTP request headers
     *
     * @var array
     */
    protected static $httpHeaders;

    /**
     * Prepared JSON string to be posted with request
     *
     * @var string
     */
    protected static $postDataJSON;


    /**
     * Prepare the data and request headers before making the call
     *
     * @param array $httpHeaders
     * @param array $dataArray
     *
     * @return void
     */
    protected static function prepareRequest($httpHeaders = array(), $dataArray = array())
    {

        self::$postDataJSON = json_encode($dataArray);

        self::$httpHeaders = $httpHeaders;

        if (!empty($dataArray)) {
            self::$httpHeaders['Content-type'] = 'application/json';
            self::$httpHeaders['Content-Length'] = strlen(self::$postDataJSON);
        }
    }

    /**
     * Implement a GET request and return json decoded output
     *
     * @param string $url
     * @param array $httpHeaders
     *
     * @return array
     */
    public static function get($url, $httpHeaders = array())
    {
        self::prepareRequest($httpHeaders);

        return self::processRequest('GET', $url);
    }

    /**
     * Implement a POST request and return json decoded output
     *
     * @param string $url
     * @param array $dataArray
     * @param array $httpHeaders
     *
     * @return array
     */
    public static function post($url, $dataArray, $httpHeaders = array())
    {
        self::prepareRequest($httpHeaders, $dataArray);

        return self::processRequest('POST', $url);
    }

    /**
     * Implement a PUT request and return json decoded output
     *
     * @param string $url
     * @param array $dataArray
     * @param array $httpHeaders
     *
     * @return array
     */
    public static function put($url, $dataArray, $httpHeaders = array())
    {
        self::prepareRequest($httpHeaders, $dataArray);

        return self::processRequest('PUT', $url);
    }

    /**
     * Implement a DELETE request and return json decoded output
     *
     * @param string $url
     * @param array $httpHeaders
     *
     * @return array
     */
    public static function delete($url, $httpHeaders = array())
    {
        self::prepareRequest($httpHeaders);

        return self::processRequest('DELETE', $url);
    }

    /**
     * Process a curl request and return decoded JSON response
     *
     * @param string $method Request http method ('GET', 'POST', 'PUT' or 'DELETE')
     * @param string $url Request URL
     *
     * @throws CurlException if response received with unexpected HTTP code.
     *
     * @return array
     */
    public static function processRequest($method, $url) {
        $retry = 0;
        $raw = null;

        while(true) {
            try {
                switch($method) {
                    case 'GET':
                        $raw = CurlRequest::get($url, self::$httpHeaders);
                        break;
                    case 'POST':
                        $raw = CurlRequest::post($url, self::$postDataJSON, self::$httpHeaders);
                        break;
                    case 'PUT':
                        $raw = CurlRequest::put($url, self::$postDataJSON, self::$httpHeaders);
                        break;
                    case 'DELETE':
                        $raw = CurlRequest::delete($url, self::$httpHeaders);
                        break;
                    default:
                        throw new \Exception("unexpected request method '$method'");
                }

                return self::processResponse($raw);
            } catch(\Exception $e) {
                if (!self::shouldRetry($raw, $e, $retry++)) {
                    throw $e;
                }
            }
        }
    }

    /**
     * Evaluate if send again a request
     *
     * @param string $response Raw request response
     * @param exception $error the request error occured
     * @param integer $retry the current number of retry
     *
     * @return bool
     */
    public static function shouldRetry($response, $error, $retry) {
        $config = ShopifySDK::$config;

        if (isset($config['RequestRetryCallback'])) {
           return $config['RequestRetryCallback']($response, $error, $retry);
        }

        return false;
    }

    /**
     * Decode JSON response
     *
     * @param string $response
     *
     * @return array
     */
    protected static function processResponse($response)
    {
        $responseArray = json_decode($response, true);

        if ($responseArray === null) {
            //Something went wrong, Checking HTTP Codes
            $httpOK = 200; //Request Successful, OK.
            $httpCreated = 201; //Create Successful.
            $httpDeleted = 204; //Delete Successful
            $httpOther = 303; //See other (headers).

            $lastHttpResponseHeaders = CurlRequest::$lastHttpResponseHeaders;

            //should be null if any other library used for http calls
            $httpCode = CurlRequest::$lastHttpCode;

            if ($httpCode == $httpOther && array_key_exists('location', $lastHttpResponseHeaders)) {
                return ['location' => $lastHttpResponseHeaders['location']];
            }

            if ($httpCode != null && $httpCode != $httpOK && $httpCode != $httpCreated && $httpCode != $httpDeleted) {
                throw new Exception\CurlException("Request failed with HTTP Code $httpCode.", $httpCode);
            }
        }

        return $responseArray;
    }
}
