<?php
/**
 * @author Arsenii Lozytskyi <manwe64@gmail.com>
 * Created at 04/15/18 02:25 PM UTC+03:00
 *
 * @see https://help.shopify.com/api/reference/inventoryitem
 */

namespace PHPShopify;

class InventoryItem extends ShopifyResource
{
    /** @inheritDoc */
    protected $resourceKey = 'inventory_item';
}
