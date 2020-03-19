<?php
/**
 * @see https://help.shopify.com/api/reference/refund
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @method array calculate()      Calculate a Refund.
 */
class Refund extends ShopifyResource {
    protected $resourceKey = 'refund';
    protected $customPostActions = [
        'calculate'
    ];
}
