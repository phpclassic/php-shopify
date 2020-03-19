<?php

namespace PHPShopify;

class TestResource extends \PHPUnit_Framework_TestCase {
    /** @var ShopifySDK */
    public static $shopify;

    public static function setUpBeforeClass() {
        $config = [
            'ShopUrl' => getenv('SHOPIFY_SHOP_URL'),
            'ApiKey' => getenv('SHOPIFY_API_KEY'),
            'Password' => getenv('SHOPIFY_API_PASSWORD'),
        ];

        self::$shopify = new ShopifySDK($config);
        ShopifySDK::checkApiCallLimit();
    }

    public static function tearDownAfterClass() {
        self::$shopify = null;
    }
}
