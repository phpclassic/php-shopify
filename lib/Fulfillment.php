<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 3:04 PM
 */

namespace PHPShopify;


class Fulfillment extends ShopifyAPI
{
    protected $resourceKey = 'fulfillment';
    protected $childResource = array(
        'FulfillmentEvent' => 'Event',
    );
    protected $customPostActions = array(
        'complete',
        'open',
        'cancel',
    );
}