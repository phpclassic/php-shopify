<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 2:59 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/order Shopify API Reference for Order
 */

namespace PHPShopify;



/**
 * --------------------------------------------------------------------------
 * Order -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read Fulfillment $Fulfillment
 * @property-read OrderRisk $Risk
 * @property-read Refund $Refund
 * @property-read Transaction $Transaction
 * @property-read Event $Event
 * @property-read Metafield $Metafield
 *
 * @method Fulfillment Fulfillment(integer $id = null)
 * @method OrderRisk Risk(integer $id = null)
 * @method Refund Refund(integer $id = null)
 * @method Transaction Transaction(integer $id = null)
 * @method Event Event(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 *
 * --------------------------------------------------------------------------
 * Order -> Custom actions
 * --------------------------------------------------------------------------
 * @method array close()     Close an Order
 * @method array open()         Re-open a closed Order
 * @method array cancel(array $data)  Cancel an Order
 *
 */
class Order extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'order';

    /**
     * @inheritDoc
     */
    protected $childResource = array (
        'Fulfillment',
		'FulfillmentOrder',
        'OrderRisk' => 'Risk',
        'Refund',
        'Transaction',
        'Event',
        'Metafield',
    );

    /**
     * @inheritDoc
     */
    protected $customPostActions = array(
        'close',
        'open',
        'cancel',
    );
}