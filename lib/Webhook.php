<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 8:07 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/webhook Shopify API Reference for Webhook
 */

namespace PHPShopify;


class Webhook extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'webhook';
}