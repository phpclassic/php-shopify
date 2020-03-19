<?php
/**
 * @see https://help.shopify.com/api/reference/sales_channels/productlisting
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class ProductListing extends ShopifyResource {
    protected $resourceKey = 'product_listing';
    protected $customGetActions = [
        'product_ids' => 'productIds'
    ];
}
