<?php
/**
 * Created by PhpStorm.
 * @author Robert Jacobson <rjacobson@thexroadz.com>
 * Created at 11/11/19 12:26 PM UTC-05:00
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