<?php
/**
 * @see https://help.shopify.com/api/reference/discounts/pricerule Shopify API Reference for PriceRule
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read ShopifyResource $DiscountCode
 * @method ShopifyResource DiscountCode(integer $id = null)
 */
class PriceRule extends ShopifyResource
{
    public $resourceKey = 'price_rule';
    public $countEnabled = false;
    protected $childResource = [
        'DiscountCode',
    ];
}
