<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 10:54 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/collect Shopify API Reference for Collect
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class Collect extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'collect';
}