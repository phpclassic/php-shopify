<?php
/**
 * @see https://help.shopify.com/api/reference/theme
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Asset $Asset
 * @method Asset Asset(integer $id = null)
 */
class Theme extends ShopifyResource {
    public $resourceKey = 'theme';
    public $countEnabled = false;
    protected $childResource = [
        'Asset'
    ];
}
