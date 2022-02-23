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
| $shopify = new ShopifySDK($config);
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
| //GraphQL
| $data = $shopify->GraphQL->post($graphQL);
|
*/
use PHPShopify\Exception\SdkException;

/**
 * @property-read AbandonedCheckout $AbandonedCheckout
 * @property-read AccessScope $AccessScope
 * @property-read ApplicationCharge $ApplicationCharge
 * @property-read Blog $Blog
 * @property-read CarrierService $CarrierService
 * @property-read Cart $Cart
 * @property-read Collect $Collect
 * @property-read Collection $Collection
 * @property-read Comment $Comment
 * @property-read Country $Country
 * @property-read Currency $Currency
 * @property-read CustomCollection $CustomCollection
 * @property-read Customer $Customer
 * @property-read CustomerSavedSearch $CustomerSavedSearch
 * @property-read Discount $Discount
 * @property-read DiscountCode $DiscountCode
 * @property-read DraftOrder $DraftOrder
 * @property-read Event $Event
 * @property-read FulfillmentService $FulfillmentService
 * @property-read GiftCard $GiftCard
 * @property-read InventoryItem $InventoryItem
 * @property-read InventoryLevel $InventoryLevel
 * @property-read Location $Location
 * @property-read Metafield $Metafield
 * @property-read Multipass $Multipass
 * @property-read Order $Order
 * @property-read Page $Page
 * @property-read Policy $Policy
 * @property-read Product $Product
 * @property-read ProductListing $ProductListing
 * @property-read ProductVariant $ProductVariant
 * @property-read PriceRule $PriceRule
 * @property-read RecurringApplicationCharge $RecurringApplicationCharge
 * @property-read Redirect $Redirect
 * @property-read Report $Report
 * @property-read ScriptTag $ScriptTag
 * @property-read ShippingZone $ShippingZone
 * @property-read Shop $Shop
 * @property-read SmartCollection $SmartCollection
 * @property-read ShopifyPayment $ShopifyPayment
 * @property-read TenderTransaction $TenderTransaction
 * @property-read Theme $Theme
 * @property-read User $User
 * @property-read Webhook $Webhook
 * @property-read GraphQL $GraphQL
 *
 * @method AbandonedCheckout AbandonedCheckout(integer $id = null)
 * @method AccessScope AccessScope()
 * @method ApplicationCharge ApplicationCharge(integer $id = null)
 * @method Blog Blog(integer $id = null)
 * @method CarrierService CarrierService(integer $id = null)
 * @method Cart Cart(string $cart_token = null)
 * @method Collect Collect(integer $id = null)
 * @method Collection Collection(integer $id = null)
 * @method Comment Comment(integer $id = null)
 * @method Country Country(integer $id = null)
 * @method Currency Currency(integer $id = null)
 * @method CustomCollection CustomCollection(integer $id = null)
 * @method Customer Customer(integer $id = null)
 * @method CustomerSavedSearch CustomerSavedSearch(integer $id = null)
 * @method Discount Discount(integer $id = null)
 * @method DraftOrder DraftOrder(integer $id = null)
 * @method DiscountCode DiscountCode(integer $id = null)
 * @method Event Event(integer $id = null)
 * @method FulfillmentService FulfillmentService(integer $id = null)
 * @method FulfillmentOrder FulfillmentOrder(integer $id = null)
 * @method GiftCard GiftCard(integer $id = null)
 * @method InventoryItem InventoryItem(integer $id = null)
 * @method InventoryLevel InventoryLevel(integer $id = null)
 * @method Location Location(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 * @method Multipass Multipass(integer $id = null)
 * @method Order Order(integer $id = null)
 * @method Page Page(integer $id = null)
 * @method Policy Policy(integer $id = null)
 * @method Product Product(integer $id = null)
 * @method ProductListing ProductListing(integer $id = null)
 * @method ProductVariant ProductVariant(integer $id = null)
 * @method PriceRule PriceRule(integer $id = null)
 * @method RecurringApplicationCharge RecurringApplicationCharge(integer $id = null)
 * @method Redirect Redirect(integer $id = null)
 * @method Report Report(integer $id = null)
 * @method ScriptTag ScriptTag(integer $id = null)
 * @method ShippingZone ShippingZone(integer $id = null)
 * @method Shop Shop(integer $id = null)
 * @method ShopifyPayment ShopifyPayment()
 * @method SmartCollection SmartCollection(integer $id = null)
 * @method TenderTransaction TenderTransaction()
 * @method Theme Theme(int $id = null)
 * @method User User(integer $id = null)
 * @method Webhook Webhook(integer $id = null)
 * @method GraphQL GraphQL()
 */
class ShopifySDK
{
    /**
     * List of available resources which can be called from this client
     *
     * @var string[]
     */
    protected $resources = array(
        'AbandonedCheckout',
        'AccessScope',
        'ApplicationCharge',
        'Blog',
        'CarrierService',
        'Cart',
        'Collect',
        'Collection',
        'Comment',
        'Country',
        'Currency',
        'CustomCollection',
        'Customer',
        'CustomerSavedSearch',
        'Discount',
        'DiscountCode',
        'DraftOrder',
        'Event',
        'FulfillmentService',
        'FulfillmentOrder',
        'GiftCard',
        'InventoryItem',
        'InventoryLevel',
        'Location',
        'Metafield',
        'Multipass',
        'Order',
        'Page',
        'Policy',
        'Product',
        'ProductListing',
        'ProductVariant',
        'PriceRule',
        'RecurringApplicationCharge',
        'Redirect',
        'Report',
        'ScriptTag',
        'ShippingZone',
        'Shop',
        'SmartCollection',
        'ShopifyPayment',
        'TenderTransaction',
        'Theme',
        'User',
        'Webhook',
        'GraphQL'
    );

    /**
     * @var float microtime of last api call
     */
    public static $microtimeOfLastApiCall;

    /**
     * @var float Minimum gap in seconds to maintain between 2 api calls
     */
    public static $timeAllowedForEachApiCall = .5;

    /**
     * @var string Default Shopify API version
     */
    public static $defaultApiVersion = '2022-01';

    /**
     * Shop / API configurations
     *
     * @var array
     */
    public static $config = array(
    );

    /**
     * List of resources which are only available through a parent resource
     *
     * @var array Array key is the child resource name and array value is the parent resource name
     */
    protected $childResources = array(
        'Article'           => 'Blog',
        'Asset'             => 'Theme',
        'Balance'           => 'ShopifyPayment',
        'CustomerAddress'   => 'Customer',
        'Dispute'           => 'ShopifyPayment',
        'Fulfillment'       => 'Order',
        'FulfillmentEvent'  => 'Fulfillment',
        'OrderRisk'         => 'Order',
        'Payouts'           => 'ShopifyPayment',
        'ProductImage'      => 'Product',
        'ProductVariant'    => 'Product',
        'DiscountCode'      => 'PriceRule',
        'Province'          => 'Country',
        'Refund'            => 'Order',
        'Transaction'       => 'Order',
        'Transactions'      => 'Balance',
        'UsageCharge'       => 'RecurringApplicationCharge',
    );

    /*
     * ShopifySDK constructor
     *
     * @param array $config
     *
     * @return void
     */
    public function __construct($config = array())
    {
        if(!empty($config)) {
            ShopifySDK::config($config);
        }
    }

    /**
     * Return ShopifyResource instance for a resource.
     * @example $shopify->Product->get(); //Returns all available Products
     * Called like an object properties (without parenthesis)
     *
     * @param string $resourceName
     *
     * @return ShopifyResource
     */
    public function __get($resourceName)
    {
        return $this->$resourceName();
    }

    /**
     * Return ShopifyResource instance for a resource.
     * Called like an object method (with parenthesis) optionally with the resource ID as the first argument
     * @example $shopify->Product($productID); //Return a specific product defined by $productID
     *
     * @param string $resourceName
     * @param array $arguments
     *
     * @throws SdkException if the $name is not a valid ShopifyResource resource.
     *
     * @return ShopifyResource
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
        $resource = new $resourceClassName($resourceID);

        return $resource;
    }

    /**
     * Configure the SDK client
     *
     * @param array $config
     *
     * @return ShopifySDK
     */
    public static function config($config)
    {
        /**
         * Reset config to it's initial values
         */
        self::$config = array(
            'ApiVersion' => self::$defaultApiVersion
        );

        foreach ($config as $key => $value) {
            self::$config[$key] = $value;
        }

        //Re-set the admin url if shop url is changed
        if(isset($config['ShopUrl'])) {
            self::setAdminUrl();
        }

        //If want to keep more wait time than .5 seconds for each call
        if (isset($config['AllowedTimePerCall'])) {
            static::$timeAllowedForEachApiCall = $config['AllowedTimePerCall'];
        }

        if (isset($config['Curl']) && is_array($config['Curl'])) {
            CurlRequest::config($config['Curl']);
        }

        return new ShopifySDK;
    }

    /**
     * Set the admin url, based on the configured shop url
     *
     * @return string
     */
    public static function setAdminUrl()
    {
        $shopUrl = self::$config['ShopUrl'];

        //Remove https:// and trailing slash (if provided)
        $shopUrl = preg_replace('#^https?://|/$#', '', $shopUrl);
        $apiVersion = self::$config['ApiVersion'];

        if(isset(self::$config['ApiKey']) && isset(self::$config['Password'])) {
            $apiKey = self::$config['ApiKey'];
            $apiPassword = self::$config['Password'];
            $adminUrl = "https://$apiKey:$apiPassword@$shopUrl/admin/";
        } else {
            $adminUrl = "https://$shopUrl/admin/";
        }

        self::$config['AdminUrl'] = $adminUrl;
        self::$config['ApiUrl'] = $adminUrl . "api/$apiVersion/";

        return $adminUrl;
    }

    /**
     * Get the admin url of the configured shop
     *
     * @return string
     */
    public static function getAdminUrl() {
        return self::$config['AdminUrl'];
    }

    /**
     * Get the api url of the configured shop
     *
     * @return string
     */
    public static function getApiUrl() {
        return self::$config['ApiUrl'];
    }

    /**
     * Maintain maximum 2 calls per second to the API
     *
     * @see https://help.shopify.com/api/guides/api-call-limit
     *
     * @param bool $firstCallWait Whether to maintain the wait time even if it is the first API call
     */
    public static function checkApiCallLimit($firstCallWait = false)
    {
        $timeToWait = 0;
        if (static::$microtimeOfLastApiCall == null) {
            if ($firstCallWait) {
                $timeToWait = static::$timeAllowedForEachApiCall;
            }
        } else {
            $now = microtime(true);
            $timeSinceLastCall = $now - static::$microtimeOfLastApiCall;
            //Ensure 2 API calls per second
            if($timeSinceLastCall < static::$timeAllowedForEachApiCall) {
                $timeToWait = static::$timeAllowedForEachApiCall - $timeSinceLastCall;
            }
        }

        if ($timeToWait) {
            //convert time to microseconds
            $microSecondsToWait = $timeToWait * 1000000;
            //Wait to maintain the API call difference of .5 seconds
            usleep($microSecondsToWait);
        }

        static::$microtimeOfLastApiCall = microtime(true);
    }
}
