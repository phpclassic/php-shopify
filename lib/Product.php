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
 * @property-read ShopifyAPI $Image
 * @property-read ShopifyAPI $Variant
 * @property-read ShopifyAPI $Metafield
 * @property-read ShopifyAPI $Event
 *
 * @method ShopifyAPI Image(integer $id = null)
 * @method ShopifyAPI Variant(integer $id = null)
 * @method ShopifyAPI Metafield(integer $id = null)
 * @method ShopifyAPI Event(integer $id = null)
 *
 */
class Product extends ShopifyAPI
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'product';

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'ProductImage' => 'Image',
        'ProductVariant' => 'Variant',
        'Metafield',
        'Event'
    );
}