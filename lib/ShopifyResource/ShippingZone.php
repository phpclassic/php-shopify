<?php
/**
 * @see https://help.shopify.com/api/reference/shipping_zone
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class ShippingZone extends ShopifyResource {
    protected $resourceKey = 'shipping_zone';
    public $countEnabled = false;
    public $readOnly = true;
}
