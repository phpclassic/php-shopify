<?php
/**
 * @see https://help.shopify.com/api/reference/product Shopify API Reference for Product
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read ProductImage $Image
 * @property-read ProductVariant $Variant
 * @property-read Metafield $Metafield
 * @property-read Event $Event
 * @method ProductImage Image(integer $id = null)
 * @method ProductVariant Variant(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 * @method Event Event(integer $id = null)
 */
class Product extends ShopifyResource
{
    public $resourceKey = 'product';
    protected $childResource = [
        'ProductImage' => 'Image',
        'ProductVariant' => 'Variant',
        'Metafield',
        'Event',
    ];
}
