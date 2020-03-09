<?php
/**
 * @see https://shopify.dev/docs/admin-api/rest/reference/products/collection
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class Collection extends ShopifyResource {
    protected $resourceKey = 'collection';
    protected $childResource = [
        'Product'
    ];
}
