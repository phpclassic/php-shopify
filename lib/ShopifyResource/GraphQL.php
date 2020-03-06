<?php
/**
 * @see https://help.shopify.com/en/api/graphql-admin-api GraphQL Admin API
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\Http\HttpRequestJson;
use PHPShopify\ShopifyResource;
use PHPShopify\Exception\ApiException;
use PHPShopify\Exception\CurlException;
use PHPShopify\Exception\SdkException;

class GraphQL extends ShopifyResource
{
    protected function getResourcePath()
    {
        return 'graphql';
    }

    /**
     * Call POST method for any GraphQL request
     *
     * @param string $graphQL A valid GraphQL String. @see https://help.shopify.com/en/api/graphql-admin-api/graphiql-builder GraphiQL builder - you can build your graphql string from here.
     * @param string|null $url
     * @param array|null $variables
     * @throws ApiException if the response has an error specified
     * @throws CurlException if response received with unexpected HTTP code.
     * @return array
     */
    public function query(string $graphQL, ?string $url = null, ?array $variables = null): array
    {
        if ($url === null) {
            $url = $this->generateUrl();
        }

        $httpHeaders = $this->httpHeaders;

        if (!isset($httpHeaders['X-Shopify-Access-Token'])) {
            throw new SdkException("The GraphQL Admin API requires an access token for making authenticated requests!");
        }

        if (is_array($variables)) {
            $httpHeaders['Content-type'] = 'application/json';
            $data = json_encode(['query' => $graphQL, 'variables' => $variables]);
        } else {
            $httpHeaders['Content-type'] = 'application/graphql';
            $data = $graphQL;
        }

        return $this->processResponse(HttpRequestJson::post($url, $data, $this->httpHeaders));
    }

    /**
     * @inheritdoc
     * @throws SdkException
     */
    public function get($urlParams = [], $url = null, $dataKey = null)
    {
        throw new SdkException("Only POST method is allowed for GraphQL!");
    }

    /**
     * @inheritdoc
     * @throws SdkException
     */
    public function put($dataArray, $url = null, $wrapData = true)
    {
        throw new SdkException("Only POST method is allowed for GraphQL!");
    }

    /**
     * @inheritdoc
     * @throws SdkException
     */
    public function delete($urlParams = [], $url = null)
    {
        throw new SdkException("Only POST method is allowed for GraphQL!");
    }
}
