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


        if (isset($config['ApiKey']) && isset($config['Password'])) {
            $config['ApiUrl'] = ShopifyClient::getAdminUrl($config['ShopUrl'], $config['ApiKey'], $config['Password']);
        } elseif (!isset($config['AccessToken'])) {
            throw new SdkException("Either AccessToken or ApiKey+Password Combination must be provided!");
        } else {
            $config['ApiUrl'] = ShopifyClient::getAdminUrl($config['ShopUrl']);
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
     * @throws SdkException if the $name is not a valid ShopifyAPI resource.
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

    /**
     * Return the admin url, based on a given shop url
     *
     * @param string $shopUrl
     * @param string $apiKey
     * @param string $apiPassword
     * @return string
     */
    public static function getAdminUrl($shopUrl, $apiKey = null, $apiPassword = null)
    {
        //Remove https:// and trailing slash (if provided)
        $shopUrl = preg_replace('#^https?://|/$#', '', $shopUrl);

        if($apiKey && $apiPassword) {
            $adminUrl = "https://$apiKey:$apiPassword@$shopUrl/admin/";
        } else {
            $adminUrl = "https://$shopUrl/admin/";
        }
        return $adminUrl;
    }

    /**
     * Verify if the request is made from shopify using hmac hash value
     *
     * @throws SdkException if hmac is not found in the url parameters
     *
     * @param string $sharedSecret Shared Secret of the Shopify App
     *
     * @return bool
     */
    public static function verifyShopifyRequest($sharedSecret)
    {
        $data = $_GET;
        //Get the hmac and remove it from array
        if (isset($data['hmac'])) {
            $hmac = $data['hmac'];
            unset($data['hmac']);
        } else {
            throw new SdkException("HMAC value not found in url parameters.");
        }
        //signature validation is deprecated
        if (isset($data['signature'])) {
            unset($data['signature']);
        }
        //Create data string for the remaining url parameters
        $dataString = http_build_query($data);

        $realHmac = hash_hmac('sha256', $dataString, $sharedSecret);

        //hash the values before comparing (to prevent time attack)
        if(md5($realHmac) === md5($hmac)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Redirect the user to the authorization page to allow the app access to the shop
     *
     * @see https://help.shopify.com/api/guides/authentication/oauth#scopes For allowed scopes
     *
     * @param array $config
     * @param string|string[] $scopes Scopes required by app
     * @param string $redirectUrl
     *
     * @return void
     */
    public static function createAuthRequest($config, $scopes, $redirectUrl = null)
    {
        if (!$redirectUrl) {
            //If redirect url is the same as this url, then need to check for access token when redirected back from shopify
            if(isset($_GET['code'])) {
                return self::getAccessToken($config);
            } else {
                $redirectUrl = self::getCurrentUrl();
            }
        }

        if (is_array($scopes)) {
            $scopes = join(',', $scopes);
        }
        $authUrl = self::getAdminUrl($config['ShopUrl']) . 'oauth/authorize?client_id=' . $config['ApiKey'] . '&redirect_uri=' . $redirectUrl . "&scope=$scopes";

        header("Location: $authUrl");
    }

    /**
     * Get Access token for the API
     * Call this when being redirected from shopify page ( to the $redirectUrl) after authentication
     *
     * @param array $config
     *
     * @return string
     */
    public static function getAccessToken($config)
    {
        if(self::verifyShopifyRequest($config['SharedSecret'])) {
            $data = array(
                'client_id' => $config['ApiKey'],
                'client_secret' => $config['SharedSecret'],
                'code' => $_GET['code'],
            );

            $response = HttpRequestJson::post(self::getAdminUrl($config['ShopUrl']) . 'oauth/access_token', $data);

            return isset($response['access_token']) ? $response['access_token'] : null;
        }
    }

    /**
     * Get the url of the current page
     *
     * @return string
     */
    public static function getCurrentUrl()
    {
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https';
        }
        else {
            $protocol = 'http';
        }

        return "$protocol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}