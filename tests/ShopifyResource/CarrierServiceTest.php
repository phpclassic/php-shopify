<?php

namespace PHPShopify\ShopifyResource;

use PHPShopify\TestSimpleResource;

class CarrierServiceTest extends TestSimpleResource {
    public $postArray = [
        "name" => "Shipping Rate Provider",
        "callback_url" => "http://shippingrateprovider.com",
        "service_discovery" => true
    ];
    public $putArray = [
        "name" => "Updated Shipping Rate Provider",
        "active" => false
    ];
}
