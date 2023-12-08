<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 12:07 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/customeraddress Shopify API Reference for CustomerAddress
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * GiftCardAdjustment -> Custom actions
 * --------------------------------------------------------------------------
 * @method array makeDefault()      Sets the address as default for the customer
 *
 */
class GiftCardAdjustment extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'adjustment';

    /**
     * @inheritDoc
     */
    protected function pluralizeKey()
    {
        return 'adjustments';
    }


}
