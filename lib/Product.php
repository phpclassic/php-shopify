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
 *
 * @method ShopifyAPI Image(integer $id = null)
 * @method ShopifyAPI Variant(integer $id = null)
 * @method ShopifyAPI Metafield(integer $id = null)
 *
 */
class Product extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    public $resourceKey = 'product';

    /**
     * List of child Resource names / classes
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = array(
        'ProductImage' => 'Image',
        'ProductVariant' => 'Variant',
        'Metafield',
    );
}