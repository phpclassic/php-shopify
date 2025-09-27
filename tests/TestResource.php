<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/9/16 12:28 PM UTC+06:00
 */

namespace PHPShopify;

class TestResource extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ShopifySDK $shopify;
     */
    public static $shopify;

    /**
     * @inheritDoc
     */
    public static function setUpBeforeClass()
    {
        $config = array(
            'ShopUrl' => getenv('SHOPIFY_SHOP_URL'), //Your shop URL
            'ApiKey' => getenv('SHOPIFY_API_KEY'), //Your Private API Key
            'Password' => getenv('SHOPIFY_API_PASSWORD'), //Your Private API Password
            'AccessToken' => getenv('SHOPIFY_API_PASSWORD'), //Your Access Token(Private API Password)
        );

        self::$shopify = ShopifySDK::config($config);
        ShopifySDK::checkApiCallLimit();
    }

    /**
     * @inheritDoc
     */
    public static function tearDownAfterClass()
    {
        self::$shopify = null;
    }
}