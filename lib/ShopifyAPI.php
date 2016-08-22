<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/17/16 3:14 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference Shopify API Reference
 */

namespace PHPShopify;

use PHPShopify\Exception\ApiException;
use PHPShopify\Exception\SdkException;
use PHPShopify\Exception\CurlException;

/*
|--------------------------------------------------------------------------
| Shopify API SDK Base Class
|--------------------------------------------------------------------------
|
| This class handles get, post, put, delete and any other custom actions for the API
|
*/
abstract class ShopifyAPI
{
    /**
     * Shop / API configurations
     *
     * @var array
     */
    protected $config;

    /**
     * HTTP request headers
     *
     * @var array
     */
    protected $httpHeaders;

    /**
     * Prepared JSON string to be posted with request
     *
     * @var string
     */
    protected $postDataJSON;

    /**
     * The base URL of the API Resource (excluding the '.json' extension).
     *
     * Example : https://myshop.myshopify.com/admin/products
     *
     * @var string
     */
    protected $resourceUrl;

    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey;

    /**
     * List of child Resource names / classes
     * 
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = array();

    /**
     * If search is enabled for the resource
     *
     * @var boolean
     */
    protected $searchEnabled = false;

    /**
     * If the resource is read only. (No POST / PUT / DELETE actions)
     *
     * @var boolean
     */
    public $readOnly = false;

    /**
     * List of custom GET / POST / PUT / DELETE actions
     *
     * Custom actions can be used without calling the get(), post(), put(), delete() methods directly
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name
     * and key will be the associated path to be used with the action.
     *
     * @var array $customGetActions
     * @var array $customPostActions
     * @var array $customPutActions
     * @var array $customDeleteActions
     */
    protected $customGetActions = array();
    protected $customPostActions = array();
    protected $customPutActions = array();
    protected $customDeleteActions = array();

    /**
     * The ID of the resource
     *
     * If provided, the actions will be called against that specific resource ID
     *
     * @var integer
     */
    public $id;

    /**
     * Create a new Shopify API resource instance.
     *
     * @param  array  $config
     * @param integer $id
     *
     * @return void
     */
    public function __construct($config, $id = null)
    {
        $this->id = $id;

        $this->config = $config;

        $parentResource = isset($config['ParentResource']) ? $config['ParentResource'] : '';

        $this->resourceUrl = $config['ApiUrl'] . $parentResource . $this->getResourcePath() . ($this->id ? '/' . $this->id : '');
    }

    /**
     * Return ShopifyAPI instance for the child resource.
     *
     * @example $shopify->Product($productID)->Image->get(); //Here Product is the parent resource and Image is a child resource
     * Called like an object properties (without parenthesis)
     *
     * @param string $childName
     *
     * @return ShopifyAPI
     */
    public function __get($childName)
    {
        return $this->$childName();
    }

    /**
     * Return ShopifyAPI instance for the child resource or call a custom action for the resource
     *
     * @example $shopify->Product($productID)->Image($imageID)->get(); //Here Product is the parent resource and Image is a child resource
     * Called like an object method (with parenthesis) optionally with the resource ID as the first argument
     * @example $shopify->Discount($discountID)->enable(); //Calls custom action enable() on Discount resource
     *
     * Note : If the $name starts with an uppercase letter, it's considered as a child class and a custom action otherwise
     *
     * @param string $name
     * @param array $arguments
     *
     * @throws SdkException if the $name is not a valid child resource or custom action method.
     *
     * @return mixed / ShopifyAPI
     */
    public function __call($name, $arguments)
    {
        //If the $name starts with an uppercase letter, it's considered as a child class
        //Otherwise it's a custom action
        if (ctype_upper($name[0])) {
            //Get the array key of the childResource in the childResource array
            $childKey = array_search($name, $this->childResource);

            if ($childKey === false) {
                throw new \SdkException("Child Resource $name is not available for " . $this->getResourceName());
            }

            //If any associative key is given to the childname, then it will be considered as the class name,
            //otherwise the childname will be the class name
            $childClassName = !is_numeric($childKey) ? $childKey : $name;

            $childClass = __NAMESPACE__ . "\\" . $childClassName;

            $config = $this->config;

            //Set the parent resource path for the child class
            $config['ParentResource'] = (isset($config['ParentResource']) ? $config['ParentResource'] : '') . $this->getResourcePath() . '/' . $this->id . '/';


            //If first argument is provided, it will be considered as the ID of the resource.
            $resourceID = !empty($arguments) ? $arguments[0] : null;


            $api = new $childClass($config, $resourceID);

            return $api;
        } else {
            $actionMaps = array(
                'post'  =>  'customPostActions',
                'put'   =>  'customPutActions',
                'get'   =>  'customGetActions',
                'delete'=>  'customDeleteActions',
            );

            //Get the array key for the action in the actions array
            foreach ($actionMaps as $httpMethod => $actionArrayKey) {
                $actionKey = array_search($name, $this->$actionArrayKey);
                if ($actionKey !== false) break;
            }

            if ($actionKey === false) {
                throw new SdkException("No action named $name is defined for " . $this->getResourceName());
            }

            //If any associative key is given to the action, then it will be considered as the method name,
            //otherwise the action name will be the method name
            $customAction = !is_numeric($actionKey) ? $actionKey : $name;


            //Get the first argument if provided with the method call
            $methodArgument = !empty($arguments) ? $arguments[0] : array();

            //Url parameters
            $urlParams = array();
            //Data body
            $dataArray = array();

            //Consider the argument as url parameters for get and delete request
            //and data array for post and put request
            if ($httpMethod == 'post' || $httpMethod == 'put') {
                $dataArray = $methodArgument;
            } else {
                $urlParams =  $methodArgument;
            }

            $url = $this->generateUrl($urlParams, $customAction);

            return $this->$httpMethod($dataArray, $url);
        }
    }

    /**
     * Get the resource name (or the class name)
     *
     * @return string
     */
    public function getResourceName()
    {
        return substr(get_called_class(), strrpos(get_called_class(), '\\') + 1);
    }

    /**
     * Get the resource key to be used for while sending data to the API
     *
     * Normally its the same as $resourceKey, when it's different, the specific resource class will override this function
     *
     * @return string
     */
    public function getResourcePostKey()
    {
        return $this->resourceKey;
    }

    /**
     * Get the pluralized version of the resource key
     *
     * Normally its the same as $resourceKey appended with 's', when it's different, the specific resource class will override this function
     *
     * @return string
     */
    protected function pluralizeKey()
    {
        return $this->resourceKey . 's';
    }

    /**
     * Get the resource path to be used to generate the api url
     *
     * Normally its the same as the pluralized version of the resource key,
     * when it's different, the specific resource class will override this function
     *
     * @return string
     */
    protected function getResourcePath()
    {
        return $this->pluralizeKey();
    }

    /**
     * Generate the custom url for api request based on the params and custom action (if any)
     *
     * @param array $urlParams
     * @param string $customAction
     *
     * @return string
     */
    public function generateUrl($urlParams = array(), $customAction = null)
    {
        return $this->resourceUrl . ($customAction ? "/$customAction" : '') . '.json' . (!empty($urlParams) ? '?' . http_build_query($urlParams) : '');
    }

    /**
     * Generate a HTTP GET request and return results as an array
     *
     * @param array $urlParams Check Shopify API reference of the specific resource for the list of URL parameters
     * @param string $url
     *
     * @uses CurlRequest::get() to send the HTTP request
     *
     * @return array
     */
    public function get($urlParams = array(), $url = null, $dataKey = null)
    {
        if (!$url) $url  = $this->generateUrl($urlParams);

        $this->prepareRequest();

        $response = CurlRequest::get($url, $this->httpHeaders);

        if (!$dataKey) $dataKey = $this->id ? $this->resourceKey : $this->pluralizeKey();

        return $this->processResponse($response, $dataKey);

    }

    /**
     * Get count for the number of resources available
     *
     * @param array $urlParams Check Shopify API reference of the specific resource for the list of URL parameters
     *
     * @return integer
     */
    public function count($urlParams = array())
    {
        $url = $this->generateUrl($urlParams, 'count');

        return $this->get(array(), $url, 'count');
    }

    /**
     * Search within the resouce
     *
     * @param mixed $query
     *
     * @throws SdkException if search is not enabled for the resouce
     *
     * @return array
     */
    public function search($query)
    {
        if (!$this->searchEnabled) {
            throw new SdkException("Search is not available for " . $this->getResourceName());
        }

        if (!is_array($query)) $query = array('query' => $query);

        $url = $this->generateUrl($query, 'search');

        return $this->get(array(), $url);
    }

    /**
     * Call POST method to create a new resource
     *
     * @param array $dataArray Check Shopify API reference of the specific resource for the list of required and optional data elements to be provided
     * @param string $url
     *
     * @uses CurlRequest::post() to send the HTTP request
     *
     * @return array
     */
    public function post($dataArray, $url = null)
    {
        if (!$url) $url = $this->generateUrl();
        
        $this->prepareRequest($dataArray);

        $response = CurlRequest::post($url, $this->postDataJSON, $this->httpHeaders);

        return $this->processResponse($response, $this->resourceKey);
    }

    /**
     * Call PUT method to update an existing resource
     *
     * @param array $dataArray Check Shopify API reference of the specific resource for the list of required and optional data elements to be provided
     * @param string $url
     *
     * @uses CurlRequest::put() to send the HTTP request
     *
     * @return array
     */
    public function put($dataArray, $url = null)
    {

        if (!$url) $url = $this->generateUrl();

        $this->prepareRequest($dataArray);

        $response = CurlRequest::put($url, $this->postDataJSON, $this->httpHeaders);

        return $this->processResponse($response, $this->resourceKey);
    }

    /**
     * Call DELETE method to delete an existing resource
     *
     * @param array $urlParams Check Shopify API reference of the specific resource for the list of URL parameters
     * @param string $url
     *
     * @uses CurlRequest::delete() to send the HTTP request
     *
     * @return array an empty array will be returned if the request is successfully completed
     */
    public function delete($urlParams = array(), $url = null)
    {
        if (!$url) $url = $this->generateUrl($urlParams);

        $this->prepareRequest();

        $response = CurlRequest::delete($url, $this->httpHeaders);

        return $this->processResponse($response);
    }

    /**
     * Prepare the data and request headers before making the call
     *
     * @param array $dataArray
     *
     * @return void
     */
    public function prepareRequest($dataArray = array())
    {
        if (!empty($dataArray)) $dataArray = $this->wrapData($dataArray);

        $this->postDataJSON = json_encode($dataArray);

        $this->httpHeaders = array();

        if (isset($this->config['AccessToken'])) {
            $this->httpHeaders['X-Shopify-Access-Token'] = $this->config['AccessToken'];
        }

        if (!empty($dataArray)) {
            $this->httpHeaders['Content-type'] = 'application/json';
            $this->httpHeaders['Content-Length'] = strlen($this->postDataJSON);
        }

    }

    /**
     * Wrap data array with resource key
     *
     * @param array $dataArray
     * @param string $dataKey
     *
     * @internal
     *
     * @return array
     */
    protected function wrapData($dataArray, $dataKey = null)
    {
        if (!$dataKey) $dataKey = $this->getResourcePostKey();

        return array($dataKey => $dataArray);
    }

    /**
     * Convert an array to string
     *
     * @param array $array
     *
     * @internal
     *
     * @return string
     */
    protected function castString($array)
    {
        if (is_string($array)) return $array;

        $string = '';
        $i = 0;
        foreach ($array as $key => $val) {
            //Add values separated by comma
            //prepend the key string, if it's an associative key
            //Check if the value itself is another array to be converted to string
            $string .= ($i === $key ? '' : "$key - ") . $this->castString($val) . ', ';
            $i++;
        }

        //Remove trailing comma and space
        $string = rtrim($string, ', ');

        return $string;
    }

    /**
     * Process the request response
     *
     * @param string $response JSON response from the API
     * @param string $dataKey key to be looked for in the data
     *
     * @throws ApiException if the response has an error specified
     * @throws CurlException if response received with unexpected HTTP code.
     *
     * @return array
     */
    public function processResponse($response, $dataKey = false)
    {
        $responseArray = json_decode($response, true);

        if ($responseArray === null) {
            //Something went wrong, Checking HTTP Codes
            $httpOK = 200; //Request Successful, OK.
            $httpCreated = 201; //Create Successful.
            $httpCode = CurlRequest::$lastHttpCode;

            if ($httpCode != $httpOK && $httpCode != $httpCreated) {
                throw new Exception\CurlException("Request failed with HTTP Code $httpCode.");
            }
        }

        if (isset($responseArray['errors'])) {
            $message = $this->castString($responseArray['errors']);

            throw new ApiException($message);
        }

        if ($dataKey && isset($responseArray[$dataKey])) {
            return $responseArray[$dataKey];
        } else {
            return $responseArray;
        }
    }
}