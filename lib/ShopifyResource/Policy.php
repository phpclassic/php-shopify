<?php
/**
 * @see https://help.shopify.com/api/reference/policy
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class Policy extends ShopifyResource {
    protected $resourceKey = 'policy';
    public $countEnabled = false;
    public $readOnly = true;

    public function pluralizeKey(): string {
        return 'policies';
    }
}
