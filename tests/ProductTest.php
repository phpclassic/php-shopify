<?php

namespace PHPShopify;

class ProductTest extends TestSimpleResource
{
    public $postArray = [
        "title" => "Burton Custom Freestlye 151",
        "body_html" => "<strong>Good snowboard!</strong>",
        "vendor" => "Burton",
        "product_type" => "Snowboard",
        "variants" => [
            [
                "option1" => "First",
                "price" => "10.00",
                "sku" => 123
            ],
            [
                "option1" => "Second",
                "price" => "20.00",
                "sku" => "123"
            ],
        ],
    ];
    public $errorPostArray = ["description" => "A mystery!"];
    public $putArray = ["title" => "New product title"];
}
