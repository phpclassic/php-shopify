<?php
/**
 * @see https://help.shopify.com/api/reference/country
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Province $Province
 * @method Province Province(integer $id = null)
 */
class Country extends ShopifyResource {
    protected $resourceKey = 'country';
    protected $childResource = [
        'Province'
    ];

    protected function pluralizeKey(): string {
        return 'countries';
    }
}
