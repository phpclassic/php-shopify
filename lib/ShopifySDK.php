<?php
/**
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
 * @property-read ShopifyResource\AbandonedCheckout $AbandonedCheckout
 * @property-read ShopifyResource\Blog $Blog
 * @property-read ShopifyResource\CarrierService $CarrierService
 * @property-read ShopifyResource\Collect $Collect
 * @property-read ShopifyResource\Comment $Comment
 * @property-read ShopifyResource\Country $Country
 * @property-read ShopifyResource\Currency $Currency
 * @property-read ShopifyResource\CustomCollection $CustomCollection
 * @property-read ShopifyResource\Customer $Customer
 * @property-read ShopifyResource\CustomerSavedSearch $CustomerSavedSearch
 * @property-read ShopifyResource\Discount $Discount
 * @property-read ShopifyResource\DiscountCode $DiscountCode
 * @property-read ShopifyResource\DraftOrder $DraftOrder
 * @property-read ShopifyResource\PriceRule $PriceRule
 * @property-read ShopifyResource\Event $Event
 * @property-read ShopifyResource\FulfillmentService $FulfillmentService
 * @property-read ShopifyResource\GiftCard $GiftCard
 * @property-read ShopifyResource\InventoryItem $InventoryItem
 * @property-read ShopifyResource\InventoryLevel $InventoryLevel
 * @property-read ShopifyResource\Location $Location
 * @property-read ShopifyResource\Metafield $Metafield
 * @property-read ShopifyResource\Multipass $Multipass
 * @property-read ShopifyResource\Order $Order
 * @property-read ShopifyResource\Page $Page
 * @property-read ShopifyResource\Policy $Policy
 * @property-read ShopifyResource\Product $Product
 * @property-read ShopifyResource\ProductListing $ProductListing
 * @property-read ShopifyResource\ProductVariant $ProductVariant
 * @property-read ShopifyResource\RecurringApplicationCharge $RecurringApplicationCharge
 * @property-read ShopifyResource\Redirect $Redirect
 * @property-read ShopifyResource\ScriptTag $ScriptTag
 * @property-read ShopifyResource\ShippingZone $ShippingZone
 * @property-read ShopifyResource\Shop $Shop
 * @property-read ShopifyResource\SmartCollection $SmartCollection
 * @property-read ShopifyResource\Theme $Theme
 * @property-read ShopifyResource\User $User
 * @property-read ShopifyResource\Webhook $Webhook
 * @property-read ShopifyResource\GraphQL $GraphQL
 *
 * @method ShopifyResource\AbandonedCheckout AbandonedCheckout(integer $id = null)
 * @method ShopifyResource\Blog Blog(integer $id = null)
 * @method ShopifyResource\CarrierService CarrierService(integer $id = null)
 * @method ShopifyResource\Collect Collect(integer $id = null)
 * @method ShopifyResource\Comment Comment(integer $id = null)
 * @method ShopifyResource\Country Country(integer $id = null)
 * @method ShopifyResource\Currency Currency(integer $id = null)
 * @method ShopifyResource\CustomCollection CustomCollection(integer $id = null)
 * @method ShopifyResource\Customer Customer(integer $id = null)
 * @method ShopifyResource\CustomerSavedSearch CustomerSavedSearch(integer $id = null)
 * @method ShopifyResource\Discount Discount(integer $id = null)
 * @method ShopifyResource\DraftOrder DraftOrder(integer $id = null)
 * @method ShopifyResource\DiscountCode DiscountCode(integer $id = null)
 * @method ShopifyResource\PriceRule PriceRule(integer $id = null)
 * @method ShopifyResource\Event Event(integer $id = null)
 * @method ShopifyResource\FulfillmentService FulfillmentService(integer $id = null)
 * @method ShopifyResource\GiftCard GiftCard(integer $id = null)
 * @method ShopifyResource\InventoryItem InventoryItem(integer $id = null)
 * @method ShopifyResource\InventoryLevel InventoryLevel(integer $id = null)
 * @method ShopifyResource\Location Location(integer $id = null)
 * @method ShopifyResource\Metafield Metafield(integer $id = null)
 * @method ShopifyResource\Multipass Multipass(integer $id = null)
 * @method ShopifyResource\Order Order(integer $id = null)
 * @method ShopifyResource\Page Page(integer $id = null)
 * @method ShopifyResource\Policy Policy(integer $id = null)
 * @method ShopifyResource\Product Product(integer $id = null)
 * @method ShopifyResource\ProductListing ProductListing(integer $id = null)
 * @method ShopifyResource\ProductVariant ProductVariant(integer $id = null)
 * @method ShopifyResource\RecurringApplicationCharge RecurringApplicationCharge(integer $id = null)
 * @method ShopifyResource\Redirect Redirect(integer $id = null)
 * @method ShopifyResource\ScriptTag ScriptTag(integer $id = null)
 * @method ShopifyResource\ShippingZone ShippingZone(integer $id = null)
 * @method ShopifyResource\Shop Shop(integer $id = null)
 * @method ShopifyResource\SmartCollection SmartCollection(integer $id = null)
 * @method ShopifyResource\Theme Theme(int $id = null)
 * @method ShopifyResource\User User(integer $id = null)
 * @method ShopifyResource\Webhook Webhook(integer $id = null)
 * @method ShopifyResource\GraphQL GraphQL()
 */
class ShopifySDK
{
    /**
     * List of available resources which can be called from this client
     *
     * @var string[]
     */
    protected $resources = [
        'AbandonedCheckout',
        'ApplicationCharge',
        'Blog',
        'CarrierService',
        'Collect',
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
        'Theme',
        'User',
        'Webhook',
        'GraphQL'
    ];

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
    public static $defaultApiVersion = '2020-01';

    /**
     * Shop / API configurations
     * @var array
     */
    private $config = [];

    /**
     * List of resources which are only available through a parent resource
     *
     * @var array Array key is the child resource name and array value is the parent resource name
     */
    protected $childResources = [
        'Article'           => 'Blog',
        'Asset'             => 'Theme',
        'CustomerAddress'   => 'Customer',
        'Fulfillment'       => 'Order',
        'FulfillmentEvent'  => 'Fulfillment',
        'OrderRisk'         => 'Order',
        'ProductImage'      => 'Product',
        'ProductVariant'    => 'Product',
        'DiscountCode'      => 'PriceRule',
        'Province'          => 'Country',
        'Refund'            => 'Order',
        'Transaction'       => 'Order',
        'UsageCharge'       => 'RecurringApplicationCharge',
    ];

    /*
     * ShopifySDK constructor
     *
     * @param array $config
     *
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->config = $config + ['ApiVersion' => self::$defaultApiVersion];

        //Re-set the admin url if shop url is changed
        if(isset($config['ShopUrl'])) {
            self::setAdminUrl();
        }

        //If want to keep more wait time than .5 seconds for each call
        if (isset($config['AllowedTimePerCall'])) {
            static::$timeAllowedForEachApiCall = $config['AllowedTimePerCall'];
        }

        return new ShopifySDK;
    }

    /**
     * Return ShopifyResource instance for a resource.
     * @example $shopify->Product->get(); //Returns all available Products
     * Called like an object properties (without parenthesis)
     *
     * @param string $resourceName
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
    private function config(array $config)
    {

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
     * Maintain maximum 2 calls per second to the API
     *
     * @see https://help.shopify.com/api/guides/api-call-limit
     * @param bool $firstCallWait Whether to maintain the wait time even if it is the first API call
     */
    public static function checkApiCallLimit($firstCallWait = false): void
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
