<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 8/27/16 10:58 AM UTC+06:00
 */

namespace PHPShopify;


use PHPShopify\Exception\SdkException;

class AuthHelper
{
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

    /**
     * Verify if the request is made from shopify using hmac hash value
     *
     * @throws SdkException if SharedSecret is not provided or hmac is not found in the url parameters
     *
     * @return bool
     */
    public static function verifyShopifyRequest()
    {
        $data = $_GET;

        if(!isset(ShopifySDK::$config['SharedSecret'])) {
            throw new SdkException("Please provide SharedSecret while configuring the SDK client.");
        }

        $sharedSecret = ShopifySDK::$config['SharedSecret'];

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
     * @param string|string[] $scopes Scopes required by app
     * @param string $redirectUrl
     * @param bool $autoRedirect
     *
     * @throws SdkException if required configuration is not provided in $config
     *
     * @return string
     */
    public static function createAuthRequest($scopes, $redirectUrl = null, $autoRedirect = false)
    {
        $config = ShopifySDK::$config;

        if(!isset($config['ShopUrl']) || !isset($config['ApiKey'])) {
            throw new SdkException("ShopUrl and ApiKey are required for authentication request. Please check SDK configuration!");
        }

        if (!$redirectUrl) {
            if(!isset($config['SharedSecret'])) {
                throw new SdkException("SharedSecret is required for getting access token. Please check SDK configuration!");
            }

            // If redirect url is the same as this url, then need to check for access token when redirected back from shopify
            if(isset($_GET['code'])) {
                return self::getAccessToken();
            }

            $redirectUrl = self::getCurrentUrl();
        }

        if (is_array($scopes)) {
            $scopes = join(',', $scopes);
        }
        $authUrl = $config['AdminUrl'] . 'oauth/authorize?client_id=' . $config['ApiKey'] . '&redirect_uri=' . $redirectUrl . "&scope=$scopes";

        if (!$autoRedirect) {
            header("Location: $authUrl");
            exit;
        }

        return $authUrl;
    }

    /**
     * Get Access token for the API
     * Call this when being redirected from shopify page ( to the $redirectUrl) after authentication
     *
     * @throws SdkException if SharedSecret or ApiKey is missing in SDK configuration or request is not valid
     *
     * @return string
     */
    public static function getAccessToken()
    {
        $config = ShopifySDK::$config;

        if(!isset($config['SharedSecret']) || !isset($config['ApiKey'])) {
            throw new SdkException("SharedSecret and ApiKey are required for getting access token. Please check SDK configuration!");
        }

        if(self::verifyShopifyRequest()) {
            $data = array(
                'client_id' => $config['ApiKey'],
                'client_secret' => $config['SharedSecret'],
                'code' => $_GET['code'],
            );

            $response = HttpRequestJson::post($config['AdminUrl'] . 'oauth/access_token', $data);

            return isset($response['access_token']) ? $response['access_token'] : null;
        } else {
            throw new SdkException("This request is not initiated from a valid shopify shop!");
        }
    }
}