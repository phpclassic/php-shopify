<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/16/16 10:42 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/ Shopify API Reference
 */

namespace PHPShopify;


/*
|--------------------------------------------------------------------------
| Shopify API SDK Client Class
|--------------------------------------------------------------------------
|
|This class initializes the resource objects
|
|Usage:
|//For private app
|$config = array(
|   'ShopUrl' => 'yourshop.myshopify.com',
|   'ApiKey' => '***YOUR-PRIVATE-API-KEY***',
|   'Password' => '***YOUR-PRIVATE-API-PASSWORD***',
|);
|//For third party app
|$config = array(
|   'ShopUrl' => 'yourshop.myshopify.com',
|   'AccessToken' => '***ACCESS-TOKEN-FOR-THIRD-PARTY-APP***',
|);
|//Create the shopify client object
|$shopify = new ShopifyClient($config);
|
|//Get shop details
|$products = $shopify->Shop->get();
|
|//Get list of all products
|$products = $shopify->Product->get();
|
|//Get a specific product by product ID
|$products = $shopify->Product($productID)->get();
|
|//Update a product
|$updateInfo = array('title' => 'New Product Title');
|$products = $shopify->Product($productID)->put($updateInfo);
|
|//Delete a product
|$products = $shopify->Product($productID)->delete();
|
|//Create a new product
|$productInfo = array(
|   "title" => "Burton Custom Freestlye 151",
|   "body_html" => "<strong>Good snowboard!<\/strong>",
|   "vendor" => "Burton",
|   "product_type" => "Snowboard",
|);
|$products = $shopify->Product->post($productInfo);
|
|//Get variants of a product (using Child resource)
|$products = $shopify->Product($productID)->Variant->get();
|
*/
class ShopifyClient
{
    /**
     * Shop / API configurations
     *
     * @var array
     */
    protected $config;

    /*
     * ShopifyClient constructor
     *
     * @param array $config
     *
     * @return void
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Return ShopifyAPI instance for a resource.
     * @example $shopify->Product->get(); //Returns all available Products
     * Called like an object properties (without parenthesis)
     *
     * @param string $resourceName
     *
     * @return ShopifyAPI
     */
    public function __get($resourceName)
    {
        return $this->$resourceName();
    }

    /**
     * Return ShopifyAPI instance for a resource.
     * Called like an object method (with parenthesis) optionally with the resource ID as the first argument
     * @example $shopify->Product($productID); //Return a specific product defined by $productID
     *
     * @param string $resourceName
     * @param array $arguments
     *
     * @throws SdkException if the $name is not a valid resource.
     *
     * @return ShopifyAPI
     */
    public function __call($resourceName, $arguments)
    {
        $resourceClassName = __NAMESPACE__ . "\\$resourceName";
        $resource = new $resourceClassName($this->config);

        if(!empty($arguments)) {
            $resourceID = $arguments[0];
            $resource->id = $resourceID;
        }
        return $resource;
    }
}