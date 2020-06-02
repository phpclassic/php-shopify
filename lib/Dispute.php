<?php
/**
 * Created by PhpStorm.
 * @author Victor Kislichenko <v.kislichenko@gmail.com>
 * Created at 01/06/2020 16:45 AM UTC+03:00
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/shopify_payments/dispute Shopify API Reference for Dispute
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * ShopifyPayment -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyResource $DiscountCode
 *
 * @method ShopifyResource DiscountCode(integer $id = null)
 *
 */
class Dispute extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'dispute';


}