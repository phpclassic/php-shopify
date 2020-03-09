<?php
/**
 * @see https://help.shopify.com/api/reference/location Shopify API Reference for Location
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class Location extends ShopifyResource {
    protected $resourceKey = 'location';
    public $countEnabled = false;
    public $readOnly = true;
    protected $childResource = [
        'InventoryLevel'
    ];
}
