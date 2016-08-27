<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 5:51 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/metafield Shopify API Reference for Metafield
 */

namespace PHPShopify;


class Metafield extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'metafield';
}