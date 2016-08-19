<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/17/16
 * Time: 3:14 PM
 */

namespace PHPShopify;

use PHPShopify\Exception\ApiException;
use PHPShopify\Exception\SdkException;

abstract class ShopifyAPI
{
    protected $config;
    protected $httpHeaders;
    protected $postDataJSON;
    protected $apiUrl;
    protected $resourceKey;
    protected $childResource = array();
    protected $searchEnabled = false;
    protected $readOnly = false;
    protected $customGetActions = array();
    protected $customPostActions = array();
    protected $customPutActions = array();
    protected $customDeleteActions = array();
    public $id;

    public function __construct($config, $id = null)
    {
        $this->id = $id;

        $this->config = $config;
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

    public function __get($childName)
    {
        return $this->$childName();
    }

    public function __call($name, $arguments)
    {
        //if the name starts with uppercase letter then look for child classes, otherwise look for custom actions
        if(ctype_upper($name[0])) {
            $childClass = array_search($name, $this->childResource);

            if ($childClass === false) {
                throw new \Exception("Child Resource $name is not available for " . $this->getResourceName());
            } elseif (is_numeric($childClass)) {
                //If any associative key is given to the childname, then it will be considered as the class name, otherwise the childname will be the class name
                $childClass = $name;
            }

            $apiClassName = __NAMESPACE__ . "\\" . $childClass;
            $config = $this->config;
            $parentResource = (isset($config['ParentResource']) ? $config['ParentResource'] : '') . $this->getResourcePath() . '/' . $this->id . '/';

            $config['ParentResource'] = $parentResource;

            $api = new $apiClassName($config);

            if (!empty($arguments)) {
                $resourceID = $arguments[0];
                $api->id = $resourceID;
            }

            return $api;
        } else {
            $actionMaps = array(
                'post' => 'customPostActions',
                'put'  => 'customPutActions',
                'get'  =>  'customGetActions',
                'delete' => 'customDeleteActions',
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

            if (!empty($arguments)) {
                $params = $arguments[0];
            }

            $url = $this->apiUrl . ($this->id ? '/' . $this->id : '') . "/$actionKey.json";

            return $this->$httpMethod($params, $url);
        }
    }

    public function getResourceName() {
        return substr(get_called_class(), strrpos(get_called_class(), '\\') + 1);
    }

    public function getResourcePostKey() {
        return $this->resourceKey;
    }

    protected function pluralizeKey() {
        return $this->resourceKey . 's';
    }

    protected function getResourcePath() {
        return $this->pluralizeKey();
    }

    public function get($params = array(), $url = null)
    {

        if (! $url) $url = $this->apiUrl . ($this->id ? "/{$this->id}" : '') . '.json' . (!empty($params) ? '?' . http_build_query($params) : '');

        $this->prepareRequest();

        $response = CurlRequest::get($url, $this->httpHeaders);

        $dataKey = $this->id ? $this->resourceKey : $this->pluralizeKey();

        return $this->processResponse($response, $dataKey);

    }

    public function getCount($params = array(), $url = null)
    {

        if (! $url) $url = $this->apiUrl . '/count.json' . (!empty($params) ? '?' . http_build_query($params) : '');

        $this->prepareRequest();

        $response = CurlRequest::get($url, $this->httpHeaders);

        return $this->processResponse($response, 'count');
    }

    public function search($query)
    {
        if(!$this->searchEnabled) {
            throw new SdkException("Search is not available for " . $this->getResourceName());
        }

        if (! is_array($query)) $query = array('query' => $query);

        $url = $this->apiUrl . '/search.json?' . http_build_query($query);

        return $this->get(array(), $url);
    }

    public function post($data, $url = null)
    {
        if (! $url) $url = $this->apiUrl . '.json';

        $data = array($this->getResourcePostKey() => $data);
        
        $this->prepareRequest($data);

        $response = CurlRequest::post($url, $this->postDataJSON, $this->httpHeaders);

        return $this->processResponse($response, $this->resourceKey);
    }

    public function put($data, $url = null)
    {

        if (! $url) $url = $this->apiUrl . ($this->id ? "/{$this->id}" : '') .'.json';

        $data = array($this->getResourcePostKey() => $data);

        $this->prepareRequest($data);

        $response = CurlRequest::put($url, $this->postDataJSON, $this->httpHeaders);

        return $this->processResponse($response, $this->resourceKey);
    }

    public function delete($params = array(), $url = null)
    {
        if (! $url) $url = $this->apiUrl . ($this->id ? "/{$this->id}" : '') .'.json' . (!empty($params) ? '?' . http_build_query($params) : '');

        $this->prepareRequest();

        $response = CurlRequest::delete($url, $this->httpHeaders);

        return $this->processResponse($response);
    }

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

    public function castString($array)
    {
        if(is_string($array)) return $array;
        $string = '';

        foreach ($array as $key => $val) {
            $string .= "$key - " . $this->castString($val) . ', ';
        }
        $string = rtrim($string, ', ');
        return $string;
    }

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