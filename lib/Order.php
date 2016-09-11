<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 2:59 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/order Shopify API Reference for Order
 */

namespace PHPShopify;



/*
 * --------------------------------------------------------------------------
 * Order -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyResource $Fulfillment
 * @property-read ShopifyResource $Risk
 * @property-read ShopifyResource $Refund
 * @property-read ShopifyResource $Transaction
 * @property-read ShopifyResource $Event
 * @property-read ShopifyResource $Metafield
 *
 * @method ShopifyResource Fulfillment(integer $id = null)
 * @method ShopifyResource Risk(integer $id = null)
 * @method ShopifyResource Refund(integer $id = null)
 * @method ShopifyResource Transaction(integer $id = null)
 * @method ShopifyResource Event(integer $id = null)
 * @method ShopifyResource Metafield(integer $id = null)
 *
 * --------------------------------------------------------------------------
 * Order -> Custom actions
 * --------------------------------------------------------------------------
 * @method array close()     Close an Order
 * @method array open()         Re-open a closed Order
 * @method array cancel($data)  Cancel an Order
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