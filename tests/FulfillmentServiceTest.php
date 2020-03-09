<?php

namespace PHPShopify;

class FulfillmentServiceTest extends TestSimpleResource
{
    public $postArray = [
        "name" => "MarsFulfillment",
        "callback_url" => "http://google.com",
        "inventory_management" => true,
        "tracking_support" => true,
        "requires_shipping_method" => true,
        "format" => "json",
    ];

    public $putArray = [
        "tracking_support" => false,
    ];
}
