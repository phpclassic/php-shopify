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
 * CustomerOrder -> Custom actions
 * --------------------------------------------------------------------------
 * @method array get()      Sets the address as default for the customer
 *
 */
class CustomerOrder extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'order';


    /**
     * @inheritDoc
     */
    protected function pluralizeKey()
    {
        return 'orders';
    }


}
