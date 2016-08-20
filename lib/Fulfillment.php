<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 3:04 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/fulfillment Shopify API Reference for Fulfillment
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * Fulfillment -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyAPI $Event
 *
 * @method ShopifyAPI Event(integer $id = null)
 *
 * --------------------------------------------------------------------------
 * Fulfillment -> Custom actions
 * --------------------------------------------------------------------------
 * @method array complete()     Complete a fulfillment
 * @method array open()         Open a pending fulfillment
 * @method array cancel()       Cancel a fulfillment
 *
 */
class Fulfillment extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'fulfillment';

    /**
     * List of child Resource names / classes
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = array(
        'FulfillmentEvent' => 'Event',
    );

    /**
     * List of custom POST actions
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name and key will be the associated path to be used with the action.
     *
     * @var array
     */
    protected $customPostActions = array(
        'complete',
        'open',
        'cancel',
    );
}