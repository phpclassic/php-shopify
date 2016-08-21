<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 5:28 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/fulfillmentservice Shopify API Reference for FulfillmentService
 */

namespace PHPShopify;


class FulfillmentService extends ShopifyAPI
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'fulfillment_service';
}