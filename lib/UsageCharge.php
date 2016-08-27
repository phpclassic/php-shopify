<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 7:49 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/usagecharge Shopify API Reference for UsageCharge
 */

namespace PHPShopify;


class UsageCharge extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'usage_charge';
}