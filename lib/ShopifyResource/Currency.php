<?php
/**
 * @see https://help.shopify.com/en/api/reference/store-properties/currency Shopify API Reference for Currency
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class Currency extends ShopifyResource
{
    protected $resourceKey = 'currency';
    public $countEnabled = false;
    public $readOnly = true;

    public function pluralizeKey()
    {
        return 'currencies';
    }
}
