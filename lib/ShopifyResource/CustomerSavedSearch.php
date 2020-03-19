<?php
/**
 * @see https://help.shopify.com/api/reference/customersavedsearch
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Customer $Customer
 * @method Customer Customer(integer $id = null)
 */
class CustomerSavedSearch extends ShopifyResource {
    protected $resourceKey = 'customer_saved_search';
    protected $childResource = [
        'Customer'
    ];

    protected function pluralizeKey(): string {
        return 'customer_saved_searches';
    }
}
