<?php
/**
 * Created by PhpStorm.
 * @author Robert Jacobson <rjacobson@thexroadz.com>
 * @author Matthew Crigger <mcrigger@thexroadz.com>
 *
 * @see https://help.shopify.com/en/api/reference/shopify_payments/transaction Shopify API Reference for Shopify Payment Transactions
 */

namespace PHPShopify;


class Transactions extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'transaction';

    /**
     * If the resource is read only. (No POST / PUT / DELETE actions)
     *
     * @var boolean
     */
    public $readOnly = true;
}
