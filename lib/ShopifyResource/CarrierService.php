<?php
/**
 * @see https://help.shopify.com/api/reference/carrierservice
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class CarrierService extends ShopifyResource {
    protected $resourceKey = 'carrier_service';
    public $countEnabled = false;
}
