<?php
/**
 * @see https://help.shopify.com/api/reference/customcollection
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Event $Event
 * @property-read Metafield $Metafield
 * @method Event Event(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 */
class CustomCollection extends ShopifyResource {
    protected $resourceKey = 'custom_collection';
    protected $childResource = [
        'Event',
        'Metafield'
    ];
}
