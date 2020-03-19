<?php
/**
 * @see https://help.shopify.com/api/reference/inventorylevel
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @method array adjust($data)  Adjust inventory level.
 * @method array connect($data) Connect an inventory item to a location.
 * @method array set($data)     Sets an inventory level for a single inventory item within a location.
 */
class InventoryLevel extends ShopifyResource {
    protected $resourceKey = 'inventory_level';
    protected $customPostActions = [
        'adjust',
        'connect',
        'set'
    ];
}
