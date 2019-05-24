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

use \PHPShopify\Exception\SdkException;

class AuthHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowsAnExceptionWhenTheSharedSecretIsMissing()
    {
        $instance = new AuthHelper();

        try {
            $instance->verifyShopifyRequest();
        } catch (SdkException $exception) {
            $this->assertEquals(
                'Please provide SharedSecret while configuring the SDK client.',
                $exception->getMessage()
            );

            return;
        }

        $this->fail('We expected an ' . SdkException::class . ' but got none');
    }

    public function testThrowsAnexceptionWhenTheHmacIsMissing()
    {
        ShopifySDK::config([
            'ApiKey' => 'APIKEY',
            'SharedSecret' => 'SHAREDSECRET',
        ]);

        $instance = new AuthHelper();

        try {
            $instance->verifyShopifyRequest();
        } catch (SdkException $exception) {
            $this->assertEquals(
                'HMAC value not found in url parameters.',
                $exception->getMessage()
            );

            return;
        }

        $this->fail('We expected an ' . SdkException::class . ' but got none');
    }

    public function validatesTheHmacProvider()
    {
        return [
            'regular format' => [
                [
                    'hmac' => 'eb963c62040fa312d35917aa6b17186261f78ded32cc088f0753ca9854c1b2fb',
                    'locale' => 'en',
                    'shop' => 'test-example.myshopify.com',
                    'timestamp' => '1547629143',
                ],
            ],
            'with protocol=https://' => [
                [
                    'hmac' => '0a64939043800bb7cdca368a3458b06d3ac1ef7966b799551c58403d6cbe4ab9',
                    'locale' => 'en',
                    'shop' => 'test-example.myshopify.com',
                    'protocol' => 'https://',
                    'timestamp' => '1547629143',
                ],
            ],
            'with ids[] format' => [
                [
                    'hmac' => 'ec6e4f46ef4048410440757c3854cb842d358ea6e01caa78a5a641908178a7c8',
                    'ids' => [
                        '712036909111',
                        '709092507703',
                    ],
                    'locale' => 'en',
                    'shop' => 'test-example.myshopify.com',
                    'timestamp' => '1547629143',
                ],
            ],
        ];
    }

    /**
     * @dataProvider validatesTheHmacProvider
     */
    public function testValidatesTheHmac($paramters)
    {
        ShopifySDK::config([
            'ApiKey' => 'APIKEY',
            'SharedSecret' => 'SHAREDSECRET',
        ]);

        $instance = new AuthHelper();

        $result = $instance->verifyShopifyRequest($paramters);

        $this->assertTrue($result);
    }
}