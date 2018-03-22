<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/18/16 10:46 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/product Shopify API Reference for Product
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * Product -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyResource $Metafield
 *
 * @method ShopifyResource Metafield(integer $id = null)
 *
 */
class Variant extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'variant';

    protected $childResource = array(
        'Metafield'
    );
}