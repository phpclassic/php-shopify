<?php
/**
 * @see https://help.shopify.com/api/reference/order Shopify API Reference for Order
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Fulfillment $Fulfillment
 * @property-read OrderRisk $Risk
 * @property-read Refund $Refund
 * @property-read Transaction $Transaction
 * @property-read Event $Event
 * @property-read Metafield $Metafield
 * @method Fulfillment Fulfillment(integer $id = null)
 * @method OrderRisk Risk(integer $id = null)
 * @method Refund Refund(integer $id = null)
 * @method Transaction Transaction(integer $id = null)
 * @method Event Event(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 * @method array close()
 * @method array open()
 * @method array cancel(array $data)
 */
class Order extends ShopifyResource
{
    protected $resourceKey = 'order';
    protected $childResource = [
        'Fulfillment',
        'OrderRisk' => 'Risk',
        'Refund',
        'Transaction',
        'Event',
        'Metafield',
    ];
    protected $customPostActions = [
        'close',
        'open',
        'cancel',
    ];
}
