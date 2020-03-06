<?php
/**
 * @see https://help.shopify.com/api/reference/refund Shopify API Reference for Refund
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @method array calculate()      Calculate a Refund.
 */
class Refund extends ShopifyResource
{
    protected $resourceKey = 'refund';
    protected $customPostActions = [
        'calculate',
    ];
}
