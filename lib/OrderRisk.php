<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 6:10 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/order_risks Shopify API Reference for Order Risks
 */

namespace PHPShopify;


class OrderRisk extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'risk';
}