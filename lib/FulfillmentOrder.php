<?php
/**
 * Created by PhpStorm.
 * @author Mark Solly <mark@solly.com.au>
 * Created at 5/21/21 11:27 AM UTC+10:00
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/shipping-and-fulfillment/fulfillmentorder Shopify API Reference for Fulfillment Order
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * FulfillmentOrder -> Child Resources
 * --------------------------------------------------------------------------
 *
 * --------------------------------------------------------------------------
 * Fulfillment -> Custom actions
 * --------------------------------------------------------------------------
 * @method array cancel()     Cancel a fulfillment order
 * @method array open()       Open a fulfillment order
 * @method array close()       Close a fulfillment order
 * @method array move()			Move a fulfilment order to a new location
 * @method array reschedule()	Reschedule fulfill_at_time of a scheduled fulfillment order
 * @method array hold(array $data)  Hold a fulfillment order
 * @method array release_hold()     Release hold on a fulfillment order
 */
class FulfillmentOrder extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'fulfillment_order';


    /**
     * @inheritDoc
     */
    protected $customPostActions = array(
        'close',
        'open',
        'cancel',
		'move',
		'reschedule',
        'hold',
        'release_hold'
    );
}