<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 7:36 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/shipping_zone Shopify API Reference for Shipping Zone
 */

namespace PHPShopify;


class ShippingZone extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'shipping_zone';

    /**
     * @inheritDoc
     */
    public $countEnabled = false;

    /**
     * @inheritDoc
     */
    public $readOnly = true;
}