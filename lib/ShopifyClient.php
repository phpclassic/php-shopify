<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/16/16
 * Time: 10:42 AM
 */

namespace PHPShopify;


class ShopifyClient
{
    protected $config;
    protected $accessToken;
    protected $api;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function __get($apiName)
    {
        return $this->$apiName();
    }

    public function __call($apiName, $arguments)
    {
        $apiClassName = __NAMESPACE__ . "\\$apiName";
        $api = new $apiClassName($this->config);

        if(!empty($arguments)) {
            $resourceID = $arguments[0];
            $api->id = $resourceID;
        }
        return $api;
    }
}