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
 * @property-read ShopifyAPI $Fulfillment
 * @property-read ShopifyAPI $Risk
 * @property-read ShopifyAPI $Refund
 * @property-read ShopifyAPI $Transaction
 * @property-read ShopifyAPI $Event
 * @property-read ShopifyAPI $Metafield
 *
 * @method ShopifyAPI Fulfillment(integer $id = null)
 * @method ShopifyAPI Risk(integer $id = null)
 * @method ShopifyAPI Refund(integer $id = null)
 * @method ShopifyAPI Transaction(integer $id = null)
 * @method ShopifyAPI Event(integer $id = null)
 * @method ShopifyAPI Metafield(integer $id = null)
 *
 */
class Order extends ShopifyAPI
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
}