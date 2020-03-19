<?php
/**
 * @see https://help.shopify.com/api/reference/shop
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class Shop extends ShopifyResource {
    protected $resourceKey = 'shop';
    public $countEnabled = false;
    public $readOnly = true;

    public function pluralizeKey(): string {
        return 'shop';
    }
}
