<?php
/**
 * Created by PhpStorm.
 * @author Robert Jacobson <rjacobson@thexroadz.com>
 * @author Matthew Crigger <mcrigger@thexroadz.com>
 *
 * @see https://help.shopify.com/en/api/reference/shopify_payments/payout Shopify API Reference for Shopify Payment Payouts
 */

namespace PHPShopify;

/**
 * --------------------------------------------------------------------------
 * ShopifyPayment -> Child Resources
 * --------------------------------------------------------------------------
 *
 *
 */
class Payouts extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'payout';
}