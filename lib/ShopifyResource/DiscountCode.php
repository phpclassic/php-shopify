<?php
/**
 * @see https://help.shopify.com/api/reference/discounts/discountcode Shopify API Reference for PriceRule
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @method array lookup()       Retrieves the location of a discount code.
 */
class DiscountCode extends ShopifyResource {
    protected $resourceKey = 'discount_code';
    protected $customGetActions = [
        'lookup'
    ];
}
