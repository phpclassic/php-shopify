<?php
/**
 *    ______            __             __
 *   / ____/___  ____  / /__________  / /
 *  / /   / __ \/ __ \/ __/ ___/ __ \/ /
 * / /___/ /_/ / / / / /_/ /  / /_/ / /
 * \______________/_/\__/_/   \____/_/
 *    /   |  / / /_
 *   / /| | / / __/
 *  / ___ |/ / /_
 * /_/ _|||_/\__/ __     __
 *    / __ \___  / /__  / /____
 *   / / / / _ \/ / _ \/ __/ _ \
 *  / /_/ /  __/ /  __/ /_/  __/
 * /_____/\___/_/\___/\__/\___/
 *
 */

namespace PHPShopify;


use PHPShopify\Exception\SdkException;

class AuthHelperTest extends \PHPUnit_Framework_TestCase
{
    public function createAuthRequestThrowsSdkExceptionProvider()
    {
        return [
            'no config' => [
                'config' => [],
                'message' => 'ShopUrl and ApiKey are required for authentication request. Please check SDK configuration!',
            ],
            'only ShopUrl' => [
                'config' => ['ShopUrl' => ''],
                'message' => 'ShopUrl and ApiKey are required for authentication request. Please check SDK configuration!',
            ],
            'ShopUrl and ApiKey' => [
                'config' => ['ShopUrl' => '', 'ApiKey' => ''],
                'message' => 'SharedSecret is required for getting access token. Please check SDK configuration!',
            ],
        ];
    }

    /**
     * @dataProvider createAuthRequestThrowsSdkExceptionProvider
     * @param $config
     * @param $message
     * @throws SdkException
     */
    public function testCreateAuthRequestThrowsSdkException($config, $message)
    {
        $this->expectException(SdkException::class);
        $this->expectExceptionMessage($message);

        ShopifySDK::$config = $config;

        AuthHelper::createAuthRequest('read_orders');
    }

    public function testReturnsTheRedirectUrl()
    {
        $_SERVER['HTTP_HOST'] = 'myshopifyapp.com';
        $_SERVER['REQUEST_URI'] = '/test';

        ShopifySDK::$config = [
            'ShopUrl' => '',
            'ApiKey' => '',
            'SharedSecret' => '',
            'AdminUrl' => 'https://test.myshopify.com/admin/',
        ];

        $url = AuthHelper::createAuthRequest('read_orders', 'https://myshopifyapp.com/app/', true);

        $expected = 'https://test.myshopify.com/admin/oauth/authorize?client_id=';
        $expected .= '&redirect_uri=https://myshopifyapp.com/app/&scope=read_orders';
        $this->assertEquals($expected, $url);
    }
}
