<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 7:36 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/shipping_zone Shopify API Reference for Shipping Zone
 */

namespace PHPShopify;


class ShippingZone extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'shipping_zone';

    /**
     * If the resource is read only. (No POST / PUT / DELETE actions)
     *
     * @var boolean
     */
    public $readOnly = true;
}