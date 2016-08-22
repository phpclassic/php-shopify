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
| This class initializes the resource objects
|
| Usage:
| //For private app
| $config = array(
|    'ShopUrl' => 'yourshop.myshopify.com',
|    'ApiKey' => '***YOUR-PRIVATE-API-KEY***',
|    'Password' => '***YOUR-PRIVATE-API-PASSWORD***',
| );
| //For third party app
| $config = array(
|    'ShopUrl' => 'yourshop.myshopify.com',
|    'AccessToken' => '***ACCESS-TOKEN-FOR-THIRD-PARTY-APP***',
| );
| //Create the shopify client object
| $shopify = new ShopifyClient($config);
|
| //Get shop details
| $products = $shopify->Shop->get();
|
| //Get list of all products
| $products = $shopify->Product->get();
|
| //Get a specific product by product ID
| $products = $shopify->Product($productID)->get();
|
| //Update a product
| $updateInfo = array('title' => 'New Product Title');
| $products = $shopify->Product($productID)->put($updateInfo);
|
| //Delete a product
| $products = $shopify->Product($productID)->delete();
|
| //Create a new product
| $productInfo = array(
|    "title" => "Burton Custom Freestlye 151",
|    "body_html" => "<strong>Good snowboard!<\/strong>",
|    "vendor" => "Burton",
|    "product_type" => "Snowboard",
| );
| $products = $shopify->Product->post($productInfo);
|
| //Get variants of a product (using Child resource)
| $products = $shopify->Product($productID)->Variant->get();
|
*/
use PHPShopify\Exception\SdkException;

class ShopifyClient
{
    /**
     * Shop / API configurations
     *
     * @var array
     */
    protected $config;

    /**
     * List of available resources which can be called from this client
     *
     * @var string[]
     */
    protected $resources = array(
        'AbandonedCheckout',
        'ApplicationCharge',
        'Blog',
        'CarrierService',
        'Collect',
        'Comment',
        'Country',
        'CustomCollection',
        'Customer',
        'CustomerSavedSearch',
        'Discount',
        'Event',
        'FulfillmentService',
        'GiftCard',
        'Location',
        'Metafield',
        'Multipass',
        'Order',
        'Page',
        'Policy',
        'Product',
        'RecurringApplicationCharge',
        'Redirect',
        'ScriptTag',
        'ShippingZone',
        'Shop',
        'SmartCollection',
        'Theme',
        'User',
        'Webhook',
    );

    /**
     * List of resources which are only available through a parent resource
     *
     * @var array Array key is the child resource name and array value is the parent resource name
     */
    protected $childResources = array(
        'Article'           => 'Blog',
        'Asset'             => 'Theme',
        'CustomerAddress'   => 'Customer',
        'Fulfillment'       => 'Order',
        'FulfillmentEvent'  => 'Fulfillment',
        'OrderRisk'         => 'Order',
        'ProductImage'      => 'Product',
        'ProductVariant'    => 'Product',
        'Province'          => 'Country',
        'Refund'            => 'Order',
        'Transaction'       => 'Order',
        'UsageCharge'       => 'RecurringApplicationCharge',
    );

    /*
     * ShopifyClient constructor
     *
     * @param array $config
     *
     * @throws SdkException if both AccessToken and ApiKey+Password Combination are missing
     *
     * @return void
     */
    public function __construct($config)
    {
        //Remove https:// and trailing slash (if provided)
        $config['ShopUrl'] = preg_replace('#^https?://|/$#', '',$config['ShopUrl']);

        if (isset($config['ApiKey']) && isset($config['Password'])) {
            $apiKey = $config['ApiKey'];
            $password = $config['Password'];

            $config['ApiUrl'] = "https://$apiKey:$password@" . $config['ShopUrl'] . '/admin/';
        } elseif (!isset($config['AccessToken'])) {
            throw new SdkException("Either AccessToken or ApiKey+Password Combination must be provided!");
        } else {
            $config['ApiUrl'] = 'https://' . $config['ShopUrl'] . '/admin/';
        }

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
        if (!in_array($resourceName, $this->resources)) {
            if (isset($this->childResources[$resourceName])) {
                $message = "$resourceName is a child resource of " . $this->childResources[$resourceName] . ". Cannot be accessed directly.";
            } else {
                $message = "Invalid resource name $resourceName. Pls check the API Reference to get the appropriate resource name.";
            }
            throw new SdkException($message);
        }

        $resourceClassName = __NAMESPACE__ . "\\$resourceName";

        //If first argument is provided, it will be considered as the ID of the resource.
        $resourceID = !empty($arguments) ? $arguments[0] : null;

        //Initiate the resource object
        $resource = new $resourceClassName($this->config, $resourceID);

        return $resource;
    }
}