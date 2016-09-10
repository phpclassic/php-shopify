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

    public static $microtimeOfLastAPICall;

    /**
     * @inheritDoc
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

    /**
     * @inheritDoc
     */
    public static function tearDownAfterClass()
    {
        self::$shopify = null;
    }

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        if(static::$microtimeOfLastAPICall == null) {
            //Maintain 2 seconds per call
            usleep(500000);
        } else {
            $now = microtime(true);
            $timeSinceLastCall = $now - static::$microtimeOfLastAPICall;
            //Ensure 2 API calls per second
            if($timeSinceLastCall < .5) {
                $timeToWait = .5 - $timeSinceLastCall;
                //convert time to microseconds
                $microSecondsToWait = $timeToWait * 1000000;
                //Wait to maintain the API call difference of .5 seconds
                usleep($microSecondsToWait);
            }
        }
        static::$microtimeOfLastAPICall = microtime(true);
    }
}