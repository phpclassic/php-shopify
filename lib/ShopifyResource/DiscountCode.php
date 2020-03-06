<?php
/**
 * Created by PhpStorm.
 * @author Sergiu Cazac <kilobyte2007@gmail.com>
 * Created at 5/06/19 2:09 AM UTC+03:00
 *
 * @see https://help.shopify.com/api/reference/discounts/discountcode Shopify API Reference for PriceRule
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * DiscountCode -> Custom actions
 * --------------------------------------------------------------------------
 * @method array lookup()       Retrieves the location of a discount code.
 *
 */

class DiscountCode extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'discount_code';

    /**
     * @inheritDoc
     */
    protected $customGetActions = array(
        'lookup',
    );
}