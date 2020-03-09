<?php
/**
 * @see https://help.shopify.com/api/reference/fulfillment
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Event $Event
 * @method Event Event(integer $id = null)
 * @method array complete()     Complete a fulfillment
 * @method array open()         Open a pending fulfillment
 * @method array cancel()       Cancel a fulfillment
 */
class Fulfillment extends ShopifyResource {
    protected $resourceKey = 'fulfillment';
    protected $childResource = [
        'FulfillmentEvent' => 'Event'
    ];
    protected $customPostActions = [
        'complete',
        'open',
        'cancel'
    ];
}
