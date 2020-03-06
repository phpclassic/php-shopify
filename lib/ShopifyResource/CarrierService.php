<?php
/**
 * @see https://help.shopify.com/api/reference/carrierservice Shopify API Reference for CarrierService
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class CarrierService extends ShopifyResource
{
    protected $resourceKey = 'carrier_service';
    public $countEnabled = false;
}
