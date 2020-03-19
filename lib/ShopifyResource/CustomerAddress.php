<?php
/**
 * @see https://help.shopify.com/api/reference/customeraddress
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @method array makeDefault()      Sets the address as default for the customer
 */
class CustomerAddress extends ShopifyResource {
    protected $resourceKey = 'address';
    protected $customPutActions = [
        'default' => 'makeDefault'
    ];

    protected function pluralizeKey(): string {
        return 'addresses';
    }

    /**
     * Perform bulk operations against a number of addresses
     * Issue (Getting Error from API) : Internal server error
     * @param array $params
     * @return array
     */
    public function set(array $params): array {
        $url = $this->generateUrl($params, 'set');

        return $this->put([], $url);
    }
}
