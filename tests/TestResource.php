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
     * Initial setup for the tests to run
     */
    public static function setUpBeforeClass()
    {
        $config = array(
            'ShopUrl' => 'phpclassic.myshopify.com',
            'ApiKey' => '81781200c08b31208031f983ab930f2a',
            'Password' => '5260904f8293bce93ddd4d65c535faa4',
        );

        self::$shopify = ShopifySDK::config($config);
    }

    public static function tearDownAfterClass()
    {
        self::$shopify = null;
    }
}