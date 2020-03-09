<?php
/**
 * @see https://help.shopify.com/api/reference/customer
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read CustomerAddress $Address
 * @property-read Metafield $Metafield
 * @method CustomerAddress Address(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 * @method array search() Search for customers matching supplied query
 */
class Customer extends ShopifyResource {
    protected $resourceKey ='customer';
    public $searchEnabled = true;
    protected $childResource = [
        'CustomerAddress' => 'Address',
        'Metafield',
        'Order'
    ];

    public function send_invite(array $customer_invite = []): array {
        if (empty ( $customer_invite ) ) $customer_invite = new \stdClass();
        $url = $this->generateUrl([], 'send_invite');
        $dataArray = $this->wrapData($customer_invite, 'customer_invite');

        return $this->post($dataArray, $url, false);
    }
}
