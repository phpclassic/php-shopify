<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 7:27 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/shipping_rates Shopify API Reference for ShippingRate
 */

namespace PHPShopify;


class ShippingRate extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'shipping_rate';
}
