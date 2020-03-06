<?php

namespace PHPShopify;

use PHPShopify\Exception\SdkException;

class AuthHelper
{
    public static function getCurrentUrl(): string
    {
        if (
            in_array($_SERVER['HTTPS'] ?? null, ['on', 1])
            &&
            ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null) === 'https'
        ) {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }

        return "{$protocol}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    /**
     * Build a query string from a data array
     * Note: Strings should be URL encoded though?
     * This is a replacement for http_build_query because that returns an url-encoded string.
     */
    public static function buildQueryString(array $data): string
    {
        $paramStrings = [];

        foreach ($data as $key => $value) {
            $paramStrings[] = "$key=$value";
        }

        return implode('&', $paramStrings);
    }

    /**
     * Verify if the request is made from shopify using hmac hash value
     *
     * @inheritDoc
     * @throws SdkException if SharedSecret is not provided or hmac is not found in the url parameters
     */
    public static function verifyShopifyRequest(): bool
    {
        $data = $_GET;

        if(!isset(ShopifySDK::$config['SharedSecret'])) {
            throw new SdkException("Please provide SharedSecret while configuring the SDK client.");
        }

        $sharedSecret = ShopifySDK::$config['SharedSecret'];

        if (isset($data['hmac'])) {
            $hmac = $data['hmac'];
            unset($data['hmac']);
        } else {
            throw new SdkException("HMAC value not found in url parameters.");
        }

        // signature validation is deprecated
        if (isset($data['signature'])) {
            unset($data['signature']);
        }

        $dataString = self::buildQueryString($data);

        $realHmac = hash_hmac('sha256', $dataString, $sharedSecret);

        return md5($realHmac) === md5($hmac);
    }

    /**
     * Redirect the user to the authorization page to allow the app access to the shop
     *
     * @see https://help.shopify.com/api/guides/authentication/oauth#scopes For allowed scopes
     * @inheritDoc
     * @param string|string[] $scopes Scopes required by app
     * @param string[] $options
     * @throws SdkException if required configuration is not provided in $config
     */
    public static function createAuthRequest($scopes, ?string $redirectUrl = null, ?string $state = null, ?array $options = null, bool $return = false): ?string
    {
        assert(is_string($scopes) || is_array($scopes));
        $config = ShopifySDK::$config;

        if(!isset($config['ShopUrl']) || !isset($config['ApiKey'])) {
            throw new SdkException("ShopUrl and ApiKey are required for authentication request. Please check SDK configuration!");
        }

        if (!$redirectUrl) {
            if(!isset($config['SharedSecret'])) {
                throw new SdkException("SharedSecret is required for getting access token. Please check SDK configuration!");
            }

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

        if(!is_string($state)) {
            $state = '&state=' . $state;
        }

        if(!is_array($options)) {
            $options = '&grant_options[]=' . implode(',', $options);
        }

        // Official call structure
        // https://{shop}.myshopify.com/admin/oauth/authorize?client_id={api_key}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={option}
        $authUrl = "{$config['AdminUrl']}oauth/authorize?client_id={$config['ApiKey']}&redirect_uri={$redirectUrl}&scope={$scopes}{$state}{$options}";

        if ($return) {
            return $authUrl;
        }

        header("Location: $authUrl");

        return null;
    }

    /**
     * Get Access token for the API
     * Call this when being redirected from shopify page ( to the $redirectUrl) after authentication
     *
     * @inheritDoc
     * @throws SdkException if SharedSecret or ApiKey is missing in SDK configuration or request is not valid
     */
    public static function getAccessToken(?array $config): string
    {
        $config = $config ?? ShopifySDK::$config;

        if(!isset($config['SharedSecret']) || !isset($config['ApiKey'])) {
            throw new SdkException("SharedSecret and ApiKey are required for getting access token. Please check SDK configuration!");
        }

        if(self::verifyShopifyRequest()) {
            $data = [
                'client_id' => $config['ApiKey'],
                'client_secret' => $config['SharedSecret'],
                'code' => $_GET['code'],
            ];

            $response = HttpRequestJson::post("{$config['AdminUrl']}oauth/access_token", $data);

            return $response['access_token'] ?? null;
        } else {
            throw new SdkException("This request is not initiated from a valid shopify shop!");
        }
    }
}
