<?php
/**
 * @see https://help.shopify.com/api/reference/country Shopify API Reference for Country
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * --------------------------------------------------------------------------
 * Country -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read Province $Province
 *
 * @method Province Province(integer $id = null)
 *
 */
class Country extends ShopifyResource
{
    protected $resourceKey = 'country';
    protected $childResource = [
        'Province',
    ];

    protected function pluralizeKey()
    {
        return 'countries';
    }
}
