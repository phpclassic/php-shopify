<?php
/**
 * @see https://help.shopify.com/api/reference Shopify API Reference
 */

namespace PHPShopify;

use PHPShopify\Exception\ApiException;
use PHPShopify\Exception\SdkException;
use PHPShopify\Exception\CurlException;
use PHPShopify\Http\HttpRequestJson;
use PHPShopify\Http\CurlResponse;

abstract class ShopifyResource {
    /**
     * HTTP request headers
     *
     * @var array
     */
    protected $httpHeaders = [];

    /**
     * The base URL of the API Resource (excluding the '.json' extension).
     *
     * Example : https://myshop.myshopify.com/admin/products
     *
     * @var string
     */
    protected $resourceUrl;

    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey;

    /**
     * List of child Resource names / classes
     *
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = [];

    /**
     * If search is enabled for the resource
     *
     * @var boolean
     */
    public $searchEnabled = false;

    /**
     * If count is enabled for the resource
     *
     * @var boolean
     */
    public $countEnabled = true;

    /**
     * If the resource is read only. (No POST / PUT / DELETE actions)
     *
     * @var boolean
     */
    public $readOnly = false;

    /**
     * List of custom GET / POST / PUT / DELETE actions
     *
     * Custom actions can be used without calling the get(), post(), put(), delete() methods directly
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name
     * and key will be the associated path to be used with the action.
     *
     * @var array $customGetActions
     * @var array $customPostActions
     * @var array $customPutActions
     * @var array $customDeleteActions
     */
    protected $customGetActions = [];
    protected $customPostActions = [];
    protected $customPutActions = [];
    protected $customDeleteActions = [];

    /**
     * The ID of the resource
     *
     * If provided, the actions will be called against that specific resource ID
     *
     * @var integer
     */
    public $id;

    /**
     * Create a new Shopify API resource instance.
     *
     * @param integer $id
     * @param string $parentResourceUrl
     *
     * @throws SdkException if Either AccessToken or ApiKey+Password Combination is not found in configuration
     */

    /** @var ShopifySDK */
    protected $sdk;

    public function __construct(ShopifySdk $sdk, $id = null, $parentResourceUrl = '') {
        $this->id = $id;
        $this->sdk = $sdk;
        $config = $sdk->getConfig();

        $this->resourceUrl = ($parentResourceUrl ? $parentResourceUrl . '/' :  $config['ApiUrl']) . $this->getResourcePath() . ($this->id ? '/' . $this->id : '');

        if (isset($config['AccessToken'])) {
            $this->httpHeaders['X-Shopify-Access-Token'] = $config['AccessToken'];
        } elseif (!isset($config['ApiKey']) || !isset($config['Password'])) {
            throw new SdkException("Either AccessToken or ApiKey+Password Combination (in case of private API) is required to access the resources. Please check SDK configuration!");
        }
    }

    /**
     * Return ShopifyResource instance for the child resource.
     *
     * @example $shopify->Product($productID)->Image->get(); //Here Product is the parent resource and Image is a child resource
     * Called like an object properties (without parenthesis)
     *
     * @param string $childName
     *
     * @return ShopifyResource
     */
    public function __get($childName) {
        return $this->$childName();
    }

    /**
     * Return ShopifyResource instance for the child resource or call a custom action for the resource
     *
     * @example $shopify->Product($productID)->Image($imageID)->get(); //Here Product is the parent resource and Image is a child resource
     * Called like an object method (with parenthesis) optionally with the resource ID as the first argument
     * @example $shopify->Discount($discountID)->enable(); //Calls custom action enable() on Discount resource
     *
     * Note : If the $name starts with an uppercase letter, it's considered as a child class and a custom action otherwise
     *
     * @param string $name
     * @param array $arguments
     *
     * @throws SdkException if the $name is not a valid child resource or custom action method.
     *
     * @return mixed / ShopifyResource
     */
    public function __call($name, $arguments) {
        if (ctype_upper($name[0])) {
            $childKey = array_search($name, $this->childResource, true);

            if ($childKey === false) {
                throw new SdkException("Child Resource $name is not available for " . $this->getResourceName());
            }

            $childClassName = !is_numeric($childKey) ? $childKey : $name;

            return $this->sdk->createResource($childClassName, $arguments, $this->resourceUrl);
        } else {
            $actionMaps = [
                'post'  =>  $this->customPostActions,
                'put'   =>  $this->customPutActions,
                'get'   =>  $this->customGetActions,
                'delete'=>  $this->customDeleteActions,
            ];

            $actionKey = false;

            foreach ($actionMaps as $httpMethod => $actions) {
                $actionKey = array_search($name, $actions, true);

                if ($actionKey !== false) {
                    break;
                }
            }

            if ($actionKey === false) {
                throw new SdkException("No action named $name is defined for " . $this->getResourceName());
            }

            $customAction = !is_numeric($actionKey) ? $actionKey : $name;
            $methodArgument = !empty($arguments) ? $arguments[0] : [];

            $urlParams = $dataArray = [];

            if ($httpMethod == 'post' || $httpMethod == 'put') {
                $dataArray = $methodArgument;
            } else {
                $urlParams =  $methodArgument;
            }

            $url = $this->generateUrl($urlParams, $customAction);

            if ($httpMethod == 'post' || $httpMethod == 'put') {
                return $this->$httpMethod($dataArray, $url, false);
            }

            return $this->$httpMethod($dataArray, $url);
        }
    }

    /**
     * Get the resource name (or the class name)
     */
    public function getResourceName(): string {
        return substr(get_called_class(), strrpos(get_called_class(), '\\') + 1);
    }

    /**
     * Get the resource key to be used for while sending data to the API
     *
     * Normally its the same as $resourceKey, when it's different, the specific resource class will override this function
     */
    public function getResourcePostKey(): string {
        return $this->resourceKey;
    }

    /**
     * Get the pluralized version of the resource key
     *
     * Normally its the same as $resourceKey appended with 's', when it's different, the specific resource class will override this function
     */
    protected function pluralizeKey(): string {
        return $this->resourceKey . 's';
    }

    /**
     * Get the resource path to be used to generate the api url
     *
     * Normally its the same as the pluralized version of the resource key,
     * when it's different, the specific resource class will override this function
     */
    protected function getResourcePath(): string {
        return $this->pluralizeKey();
    }

    /**
     * Generate the custom url for api request based on the params and custom action (if any)
     */
    public function generateUrl(array $urlParams = [], ?string $customAction = null): string {
        return $this->resourceUrl . ($customAction ? "/{$customAction}" : '') . '.json' . (!empty($urlParams) ? '?' . http_build_query($urlParams) : '');
    }

    public function get(array $urlParams = [], ?string $url = null, $dataKey = null) {
        if (!$url) {
            $url  = $this->generateUrl($urlParams);
        }

        $response = $this->sdk->getHttpRequestJson()->get($url, $this->httpHeaders);

        if (!$dataKey) {
            $dataKey = $this->id ? $this->resourceKey : $this->pluralizeKey();
        }

        return $this->processResponse($response, $dataKey);
    }

    public function each(array $urlParams = [], ?string $url = null, $dataKey = null): \Generator {
        if (!$url) {
            $url  = $this->generateUrl($urlParams);
        }

        if (!$dataKey) {
            $dataKey = $this->id ? $this->resourceKey : $this->pluralizeKey();
        }

        while ($url !== null) {
            $response = $this->sdk->getHttpRequestJson()->get($url, $this->httpHeaders);

            $data = $response->getBody();

            if ($data === null || !count($data)) {
                break;
            }

            yield $this->processResponse($response, $dataKey);

            $url = self::getLinks($response)['next'] ?? null;
        }
    }

    public function count($urlParams = []) {
        if (!$this->countEnabled) {
            throw new SdkException("Count is not available for " . $this->getResourceName());
        }

        $url = $this->generateUrl($urlParams, 'count');

        return $this->get([], $url, 'count');
    }

    public function search($query) {
        if (!$this->searchEnabled) {
            throw new SdkException("Search is not available for " . $this->getResourceName());
        }

        if (!is_array($query)) {
            $query = ['query' => $query];
        }

        $url = $this->generateUrl($query, 'search');

        return $this->get([], $url);
    }

    public function post(?array $dataArray, ?string $url = null, bool $wrapData = true) {
        if (!$url) {
            $url = $this->generateUrl();
        }

        if ($wrapData && $dataArray !== null) {
            $dataArray = $this->wrapData($dataArray);
        }

        $response = $this->sdk->getHttpRequestJson()->post($url, $dataArray, $this->httpHeaders);

        return $this->processResponse($response, $this->resourceKey);
    }

    public function put(array $dataArray, ?string $url = null, bool $wrapData = true): array {
        if (!$url) {
            $url = $this->generateUrl();
        }

        if ($wrapData && !empty($dataArray)) {
            $dataArray = $this->wrapData($dataArray);
        }

        $response = $this->sdk->getHttpRequestJson()->put($url, $dataArray, $this->httpHeaders);

        return $this->processResponse($response, $this->resourceKey);
    }

    public function delete(array $urlParams = [], ?string $url = null): void {
        if (!$url) {
            $url = $this->generateUrl($urlParams);
        }

        $response = $this->sdk->getHttpRequestJson()->delete($url, $this->httpHeaders);
        $response = $this->processResponse($response);

        if (!is_array($response) || count($response) !== 0) {
            throw new SdkException('Unexpected API response on delete: ' . HttpRequestJson::encode($response));
        }
    }

    protected function wrapData(array $dataArray, $dataKey = null): array {
        if (!$dataKey) {
            $dataKey = $this->getResourcePostKey();
        }

        return [$dataKey => $dataArray];
    }

    protected static function castString($array): string {
        if (!is_array($array)) {
            return (string)$array;
        }

        $string = '';
        $i = 0;

        foreach ($array as $key => $val) {
            $string .= ($i === $key ? '' : "$key - ") . self::castString($val) . ', ';
            $i++;
        }

        $string = rtrim($string, ', ');

        return $string;
    }

    /**
     * @inheritDoc
     * @throws ApiException if the response has an error specified
     * @throws CurlException if response received with unexpected HTTP code.
     */
    protected static function validateResponse(CurlResponse $response, $dataKey = null) {
        $body = $response->getBody();

        if ($body === null) {
            $httpOK = 200;
            $httpCreated = 201;
            $httpCode = $response->getStatus();

            if ($httpCode !== $httpOK && $httpCode !== $httpCreated) {
                throw new Exception\CurlException("Request failed with HTTP Code $httpCode.");
            }
        }

        if (isset($body['errors'])) {
            $message = self::castString($body['errors']);

            ApiException::factory($message, $response->getStatus());
        }

        return $body;
    }

    protected function processResponse(CurlResponse $response, $dataKey = null) {
        $body = self::validateResponse($response);

        if ($dataKey !== null && isset($body[$dataKey])) {
            return $body[$dataKey];
        }

        return $body;
    }

    protected static function getLinks(CurlResponse $response): ?array {
        $linkHeader = $response->getHeader('link');

        if ($linkHeader === null) {
            return null;
        }

        $links = [];

        foreach (explode(', ', $linkHeader) as $headerLink) {
            if (preg_match('/^<(.*?)>; rel="([^"]+)"/D', $headerLink, $matches)) {
                $type = $matches[2];
                assert(in_array($type, ['next', 'previous'], true));
                assert(!array_key_exists($type, $links[$type]));
                $links[$type] = $matches[1];
            }

            assert(false);
        }

        return count($links) ? $links : null;
    }
}
