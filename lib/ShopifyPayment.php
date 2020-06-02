<?php
/**
 * Created by PhpStorm.
 * @author Victor Kislichenko <v.kislichenko@gmail.com>
 * Created at 01/06/2020 16:45 AM UTC+03:00
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/shopify_payments Shopify API Reference for ShopifyPayment
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * ShopifyPayment -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyResource $Dispute
 *
 * @method ShopifyResource Dispute(integer $id = null)
 *
 */
class ShopifyPayment extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'shopify_payment';

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'Dispute'
    );
}