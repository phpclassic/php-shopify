<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 4:49 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/fulfillmentevent Shopify API Reference for FulfillmentEvent
 */

namespace PHPShopify;


class FulfillmentEvent extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'fulfillment_event';

    /**
     * Get the resource path to be used to generate the api url
     *
     * @return string
     */
    public function getResourcePath()
    {
        return 'events';
    }

    /**
     * Get the resource key to be used for while sending data to the API
     *
     * @return string
     */
    public function getResourcePostKey()
    {
        return 'event';
    }
}