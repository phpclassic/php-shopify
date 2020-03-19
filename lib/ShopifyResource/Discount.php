<?php
/**
 * @see https://help.shopify.com/api/reference/discount
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @method array enable()       Enable a discount
 * @method array disable()      Disable a discount
 */
class Discount extends ShopifyResource {
    protected $resourceKey = 'discount';
    protected $customPostActions = [
        'enable',
        'disable'
    ];
}
