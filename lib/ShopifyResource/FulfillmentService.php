<?php
/**
 * @see https://help.shopify.com/api/reference/fulfillmentservice Shopify API Reference for FulfillmentService
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class FulfillmentService extends ShopifyResource {
    protected $resourceKey = 'fulfillment_service';
    public $countEnabled = false;
}
