<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 2:59 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/sales-channels/checkout Shopify API Reference for Checkout
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * Order -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShippingRate $ShippingRate
 *
 * @method ShippingRate ShippingRate(integer $id = null)
 *

 * --------------------------------------------------------------------------
 * Checkout -> Custom actions
 * --------------------------------------------------------------------------
 * @method array complete()         Completes Checkout without payment
 *
 */
class Checkout extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'checkout';

    /**
     * @inheritDoc
     */
    public $countEnabled = false;

    /**
     * @inheritDoc
     */
    protected $childResource = array (
        'ShippingRate',
    );
    /**
     * @inheritDoc
     */
    protected $customPostActions = array(
        'complete',
        'payments'
    );
}
