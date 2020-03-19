<?php
/**
 * @see https://help.shopify.com/api/reference/product_variant
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;


/**
 * @property-read Metafield $Metafield
 * @method Metafield Metafield(integer $id = null)
 */
class ProductVariant extends ShopifyResource {
    protected $resourceKey = 'variant';
    public $searchEnabled = true;
    protected $childResource = [
        'Metafield'
    ];
}
