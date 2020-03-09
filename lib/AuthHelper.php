<?php

namespace PHPShopify;

use PHPShopify\Exception\SdkException;
use PHPShopify\Http\HttpRequestJson;

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
            $paramStrings[] = "{$key}={$value}";
        }

        return implode('&', $paramStrings);
    }

    /**
     * Verify if the request is made from shopify using hmac hash value
     *
     * @inheritDoc
     * @throws SdkException if SharedSecret is not provided or hmac is not found in the url parameters
     */
    public static function verifyShopifyRequest(array $config, array $data): bool
    {
        $sharedSecret = $config['SharedSecret'];

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

        return $realHmac === $hmac;
    }

    /**
     * Redirect the user to the authorization page to allow the app access to the shop
     *
     * @see https://help.shopify.com/api/guides/authentication/oauth#scopes For allowed scopes
     * @inheritDoc
     * @param string|string[] $scopes Scopes required by app
     * @param string[] $options
     */
    public static function createAuthRequest(
        array $config,
        ?array $scopes,
        string $redirectUrl,
        ?string $state = null,
        ?array $options = null
    ): ?string
    {
        assert(is_string($scopes) || is_array($scopes));

        if ($scopes !== null) {
            $scopes = join(',', $scopes);
        }

        if ($state !== null) {
            $state = '&state=' . $state;
        }

        if ($options !== null) {
            $options = '&grant_options[]=' . implode(',', $options);
        }

        // Official call structure
        // https://{shop}.myshopify.com/admin/oauth/authorize?client_id={api_key}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={option}
        return "{$config['AdminUrl']}oauth/authorize?client_id={$config['ApiKey']}&redirect_uri={$redirectUrl}&scope={$scopes}{$state}{$options}";
    }

    /**
     * Get Access token for the API
     * Call this when being redirected from shopify page ( to the $redirectUrl) after authentication
     */
    public static function getAccessToken(array $config, array $data): string
    {
        if(self::verifyShopifyRequest($config)) {
            $data = [
                'client_id' => $config['ApiKey'],
                'client_secret' => $config['SharedSecret'],
                'code' => $data['code'],
            ];

            $response = HttpRequestJson::post("{$config['AdminUrl']}oauth/access_token", $data);

            return $response['access_token'] ?? null;
        } else {
            throw new SdkException("This request is not initiated from a valid shopify shop!");
        }
    }
}
