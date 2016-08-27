<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/17/16 4:46 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/scripttag Shopify API Reference for ScriptTag
 */

namespace PHPShopify;


class ScriptTag extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'script_tag';
}