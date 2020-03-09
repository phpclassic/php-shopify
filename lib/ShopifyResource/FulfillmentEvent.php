<?php
/**
 * @see https://help.shopify.com/api/reference/fulfillmentevent
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class FulfillmentEvent extends ShopifyResource {
    protected $resourceKey = 'fulfillment_event';
    public function getResourcePath(): string {
        return 'events';
    }

    public function getResourcePostKey(): string {
        return 'event';
    }
}
