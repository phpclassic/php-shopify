<?php

namespace PHPShopify;

use PHPShopify\Exception\SdkException;
use PHPShopify\Http\HttpRequestJson;

class AuthHelper
{
    /** @var array */
    protected $config;
    /** @var HttpRequestJson */
    protected $httpRequestJson;

    public function __construct(array $config, ?HttpRequestJson $httpRequestJson = null) {
        $this->config = $config;

        if ($httpRequestJson === null) {
            $httpRequestJson = new HttpRequestJson();
        }

        $this->httpRequestJson = $httpRequestJson;
    }

    public static function getCurrentUrl(): string {
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
     * Verify if the request is made from shopify using hmac hash value
     *
     * @inheritDoc
     * @see https://ecommerce.shopify.com/c/shopify-apis-and-technology/t/hmac-calculation-vs-ids-arrays-320575
     * @throws SdkException if SharedSecret is not provided or hmac is not found in the url parameters
     */
    public function verifyShopifyRequest(array $data): bool {
        $sharedSecret = $this->config['SharedSecret'];

        if (!isset($data['hmac']) || !is_string($data['hmac'])) {
            throw new SdkException("HMAC value not found in url parameters.");
        }

        $hashItems = [];

        foreach ($data as $key => $value) {
            if (in_array($key, ['hmac', 'signature'], true)) {
                continue;
            }

            if (is_array($value)) {
                $value = '["' . implode('", "', $value) . '"]';
            }

            $hashItems[$key] = "{$key}={$value}";
        }

        ksort($hashItems);
        $hashString = implode('&', $hashItems);

        return hash_hmac('sha256', $hashString, $sharedSecret) === $data['hmac'];
    }

    /**
     * Redirect the user to the authorization page to allow the app access to the shop
     *
     * @see https://help.shopify.com/api/guides/authentication/oauth#scopes For allowed scopes
     * @inheritDoc
     * @param string|string[] $scopes Scopes required by app
     * @param string[] $options
     */
    public function createAuthRequest(
        ?array $scopes,
        ?string $redirectUrl,
        ?string $state = null,
        ?array $options = null
    ): ?string {
        assert(is_string($scopes) || is_array($scopes));

        if ($redirectUrl === null) {
            $redirectUrl = static::getCurrentUrl();
        }

        if ($scopes !== null) {
            $scopes = join(',', $scopes);
        }

        if ($state !== null) {
            $state = '&state=' . $state;
        }

        if ($options !== null) {
            $options = '&grant_options[]=' . implode(',', $options);
        }

        return "{$this->config['AdminUrl']}oauth/authorize?client_id={$this->config['ApiKey']}&redirect_uri={$redirectUrl}&scope={$scopes}{$state}{$options}";
    }

    /**
     * Get Access token for the API
     * Call this when being redirected from shopify page ( to the $redirectUrl) after authentication
     */
    public function getAccessToken(array $data): ?string {
        if($this->verifyShopifyRequest($data)) {
            $data = [
                'client_id' => $config['ApiKey'],
                'client_secret' => $config['SharedSecret'],
                'code' => $data['code'],
            ];

            $response = $this->httpRequestJson->post("{$config['AdminUrl']}oauth/access_token", $data);

            return $response['access_token'] ?? null;
        }

        throw new SdkException("This request is not initiated from a valid shopify shop!");
    }
}
