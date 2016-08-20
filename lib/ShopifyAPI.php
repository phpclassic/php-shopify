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
     * Example : https://myshop.myshopify.com/admin/products
     *
     * @var string
     */
    //TODO Change $apiUrl to $resourceUrl
    protected $apiUrl;

    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey;

    /**
     * List of child Resource names / classes
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
     * Custom actions can be used without calling the get(), post(), put(), delete() methods directly
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name and key will be the associated path to be used with the action.
     *
     * @var array
     */
    protected $customGetActions = array();
    protected $customPostActions = array();
    protected $customPutActions = array();
    protected $customDeleteActions = array();

    /**
     * The ID of the resource
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
        //TODO Move the url manipulation part to ShopifyClient class
        //Remove https:// and trailing slash (if provided)
        $shopUrl = preg_replace('#^https?://|/$#', '',$config['ShopUrl']);

        $this->shopUrl = $shopUrl;

        $parentResource = isset($config['ParentResource']) ? $config['ParentResource'] : '';

        if(isset($config['ApiKey'])) {
            $apiKey = $config['ApiKey'];
            $password = $config['Password'];

            $this->apiUrl = "https://$apiKey:$password@" . $shopUrl . '/admin/' . $parentResource . $this->getResourcePath();
        } else {
            $this->apiUrl = 'https://' . $shopUrl . '/admin/' . $parentResource . $this->getResourcePath();
        }
    }

    /**
     * Return ShopifyAPI instance for the child resource.
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
        //If the $name starts with an uppercase letter, it's considered as a child class and a custom action otherwise
        if(ctype_upper($name[0])) {
            $childClass = array_search($name, $this->childResource);

            if ($childClass === false) {
                throw new \SdkException("Child Resource $name is not available for " . $this->getResourceName());
            } elseif (is_numeric($childClass)) {
                //If any associative key is given to the childname, then it will be considered as the class name, otherwise the childname will be the class name
                $childClass = $name;
            }

            $apiClassName = __NAMESPACE__ . "\\" . $childClass;
            $config = $this->config;

            //Set the parent resource path for the child class
            $config['ParentResource'] = (isset($config['ParentResource']) ? $config['ParentResource'] : '') . $this->getResourcePath() . '/' . $this->id . '/';

            $api = new $apiClassName($config);

            if (!empty($arguments)) {
                //if the first argument is provided with the call, consider it as a resource ID
                $resourceID = $arguments[0];
                $api->id = $resourceID;
            }

            return $api;
        } else {
            $actionMaps = array(
                'post'  =>  'customPostActions',
                'put'   =>  'customPutActions',
                'get'   =>  'customGetActions',
                'delete'=>  'customDeleteActions',
            );

            foreach ($actionMaps as $httpMethod => $actionArrayKey) {
                $actionKey = array_search($name, $this->$actionArrayKey);
                if($actionKey !== false) break;
            }

            if($actionKey === false) {
                throw new SdkException("No action named $name is defined for " . $this->getResourceName());
            } elseif (is_numeric($actionKey)) {
                //If any associative key is given to the action name, then it will be considered as the method name, otherwise the action name will be the method name
                $actionKey = $name;
            }

            $params = array();

            //Get the first argument if provided with the method call
            if (!empty($arguments)) {
                $params = $arguments[0];
            }

            $url = $this->apiUrl . ($this->id ? '/' . $this->id : '') . "/$actionKey.json";

            return $this->$httpMethod($params, $url);
        }
    }

    /**
     * Get the resource name (or the class name)
     *
     * @return string
     */
    public function getResourceName() {
        return substr(get_called_class(), strrpos(get_called_class(), '\\') + 1);
    }

    /**
     * Get the resource key to be used for while sending data to the API
     * Normally its the same as $resourceKey, when it's different, the specific resource class will override this function
     *
     * @return string
     */
    public function getResourcePostKey() {
        return $this->resourceKey;
    }

    /**
     * Get the pluralized version of the resource key
     * Normally its the same as $resourceKey appended with 's', when it's different, the specific resource class will override this function
     *
     * @return string
     */
    protected function pluralizeKey() {
        return $this->resourceKey . 's';
    }

    /**
     * Get the resource path to be used to generate the api url
     * Normally its the same as the pluralized version of the resource key, when it's different, the specific resource class will override this function
     *
     * @return string
     */
    protected function getResourcePath() {
        return $this->pluralizeKey();
    }

    /**
     * Generate a HTTP GET request and return results as an array
     *
     * @param array $params Check Shopify API reference of the specific resource for the list of URL parameters
     * @param string $url
     *
     * @uses CurlRequest::get() to send the HTTP request
     *
     * @return array
     */
    public function get($params = array(), $url = null)
    {

        if (! $url) $url = $this->apiUrl . ($this->id ? "/{$this->id}" : '') . '.json' . (!empty($params) ? '?' . http_build_query($params) : '');

        $this->prepareRequest();

        $response = CurlRequest::get($url, $this->httpHeaders);

        $dataKey = $this->id ? $this->resourceKey : $this->pluralizeKey();

        return $this->processResponse($response, $dataKey);

    }

    /**
     * Get count for the number of resources available
     *
     * @param array $params Check Shopify API reference of the specific resource for the list of URL parameters
     * @param string $url
     *
     * @uses CurlRequest::get() to send the HTTP request
     *
     * @return integer
     */
    public function getCount($params = array(), $url = null)
    {

        if (! $url) $url = $this->apiUrl . '/count.json' . (!empty($params) ? '?' . http_build_query($params) : '');

        $this->prepareRequest();

        $response = CurlRequest::get($url, $this->httpHeaders);

        return $this->processResponse($response, 'count');
    }

    /**
     * Search within the resouce
     *
     * @param array $params
     * @param string $url
     *
     * @throws SdkException if search is not enabled for the resouce
     *
     * @return array
     */
    public function search($query)
    {
        if(!$this->searchEnabled) {
            throw new SdkException("Search is not available for " . $this->getResourceName());
        }

        if (! is_array($query)) $query = array('query' => $query);

        $url = $this->apiUrl . '/search.json?' . http_build_query($query);

        return $this->get(array(), $url);
    }

    /**
     * Call POST method to create a new resource
     *
     * @param array $data Check Shopify API reference of the specific resource for the list of required and optional data elements to be provided
     * @param string $url
     *
     * @uses CurlRequest::post() to send the HTTP request
     *
     * @return array
     */
    public function post($data, $url = null)
    {
        if (! $url) $url = $this->apiUrl . '.json';

        $data = array($this->getResourcePostKey() => $data);
        
        $this->prepareRequest($data);

        $response = CurlRequest::post($url, $this->postDataJSON, $this->httpHeaders);

        return $this->processResponse($response, $this->resourceKey);
    }

    /**
     * Call PUT method to update an existing resource
     *
     * @param array $data Check Shopify API reference of the specific resource for the list of required and optional data elements to be provided
     * @param string $url
     *
     * @uses CurlRequest::put() to send the HTTP request
     *
     * @return array
     */
    public function put($data, $url = null)
    {

        if (! $url) $url = $this->apiUrl . ($this->id ? "/{$this->id}" : '') .'.json';

        $data = array($this->getResourcePostKey() => $data);

        $this->prepareRequest($data);

        $response = CurlRequest::put($url, $this->postDataJSON, $this->httpHeaders);

        return $this->processResponse($response, $this->resourceKey);
    }

    /**
     * Call DELETE method to delete an existing resource
     *
     * @param array $params Check Shopify API reference of the specific resource for the list of URL parameters
     * @param string $url
     *
     * @uses CurlRequest::delete() to send the HTTP request
     *
     * @return array an empty array will be returned if the request is successfully completed
     */
    public function delete($params = array(), $url = null)
    {
        if (! $url) $url = $this->apiUrl . ($this->id ? "/{$this->id}" : '') .'.json' . (!empty($params) ? '?' . http_build_query($params) : '');

        $this->prepareRequest();

        $response = CurlRequest::delete($url, $this->httpHeaders);

        return $this->processResponse($response);
    }

    /**
     * Prepare the data and request headers before making the call
     *
     * @param array $data
     *
     * @return void
     */
    public function prepareRequest($data = array())
    {

        $this->postDataJSON = json_encode($data);

        $this->httpHeaders = array();

        if(isset($this->config['AccessToken'])) {
            $this->httpHeaders['X-Shopify-Access-Token'] = $this->config['AccessToken'];
        }

        if(!empty($data)) {
            $this->httpHeaders['Content-type'] = 'application/json';
            $this->httpHeaders['Content-Length'] = strlen($this->postDataJSON);
        }

    }

    /**
     * Convert an array to string
     *
     * @param array $array
     *
     * @return string
     */
    public function castString($array)
    {
        if(is_string($array)) return $array;

        $string = '';

        foreach ($array as $key => $val) {
            $string .= "$key - " . $this->castString($val) . ', ';
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
     *
     * @return array
     */
    public function processResponse($response, $dataKey = false)
    {
        $responseArray = json_decode($response, true);

        if (isset ($responseArray['errors'])) {
            $message = $this->castString($responseArray['errors']);

            throw new ApiException($message);
        }

        if($dataKey && isset($responseArray[$dataKey])) {
            return $responseArray[$dataKey];
        } else {
            return $responseArray;
        }
    }
}