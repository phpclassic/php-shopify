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
 * @property-read ShopifyResource $Image
 * @property-read ShopifyResource $Variant
 * @property-read ShopifyResource $Metafield
 * @property-read ShopifyResource $Event
 *
 * @method ShopifyResource Image(integer $id = null)
 * @method ShopifyResource Variant(integer $id = null)
 * @method ShopifyResource Metafield(integer $id = null)
 * @method ShopifyResource Event(integer $id = null)
 *
 */
class Product extends ShopifyResource
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