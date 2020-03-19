<?php
/**
 * @see https://help.shopify.com/en/api/reference/store-properties/currency
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class Currency extends ShopifyResource {
    protected $resourceKey = 'currency';
    public $countEnabled = false;
    public $readOnly = true;

    public function pluralizeKey(): string {
        return 'currencies';
    }
}
