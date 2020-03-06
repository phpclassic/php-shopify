<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 6:25 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/province Shopify API Reference for Province
 */

namespace PHPShopify;


class Province extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'province';
}