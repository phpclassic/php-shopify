<?php
/**
 * @see https://help.shopify.com/api/reference/fulfillmentevent Shopify API Reference for FulfillmentEvent
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class FulfillmentEvent extends ShopifyResource {
    protected $resourceKey = 'fulfillment_event';
    public function getResourcePath() {
        return 'events';
    }

    public function getResourcePostKey() {
        return 'event';
    }
}
