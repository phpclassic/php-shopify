<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/18/16 10:46 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/product Shopify API Reference for Product
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * Product -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ProductImage $Image
 * @property-read ProductVariant $Variant
 * @property-read Metafield $Metafield
 * @property-read Event $Event
 *
 * @method ProductImage Image(integer $id = null)
 * @method ProductVariant Variant(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 * @method Event Event(integer $id = null)
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