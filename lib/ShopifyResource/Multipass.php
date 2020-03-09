<?php
/**
 * @see https://help.shopify.com/api/reference/multipass Shopify API Reference for Multipass
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;
use PHPShopify\Exception\ApiException;

class Multipass extends ShopifyResource {
    /**
     * @inheritDoc
     * @throws ApiException
     */
    public function __construct(int $id = null) {
        throw new ApiException("Multipass API is not available yet!");
    }
}
