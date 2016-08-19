<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 4:49 PM
 */

namespace PHPShopify;


class FulfillmentEvent extends ShopifyAPI
{
    protected $resourceKey = 'fulfillment_event';

    public function getResourcePath()
    {
        return 'events';
    }

    public function getResourcePostKey()
    {
        return 'event';
    }
}