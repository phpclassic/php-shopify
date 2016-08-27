<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 4:49 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/fulfillmentevent Shopify API Reference for FulfillmentEvent
 */

namespace PHPShopify;


class FulfillmentEvent extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'fulfillment_event';

    /**
     * @inheritDoc
     */
    public function getResourcePath()
    {
        return 'events';
    }

    /**
     * @inheritDoc
     */
    public function getResourcePostKey()
    {
        return 'event';
    }
}