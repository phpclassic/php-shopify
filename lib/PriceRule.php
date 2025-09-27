<?php
/**
 * Created by PhpStorm.
 * @author Sergiu Cazac <kilobyte2007@gmail.com>
 * Created at 5/06/19 2:06 AM UTC+03:00
 *
 * @see https://help.shopify.com/api/reference/discounts/pricerule Shopify API Reference for PriceRule
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * PriceRule -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyResource $DiscountCode
 *
 * @method ShopifyResource DiscountCode(integer $id = null)
 * @method ShopifyResource Batch()
 *
 */
class PriceRule extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'price_rule';

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'DiscountCode',
        'Batch',
    );
}
