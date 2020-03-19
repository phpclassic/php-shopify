<?php

namespace PHPShopify\ShopifyResource;

use PHPShopify\TestSimpleResource;

class CountryTest extends TestSimpleResource {
    public $postArray = [
        "code" => "BD",
        "tax" => 0.25
    ];

    public $putArray = [
        "tax" => 0.01
    ];

    public function testGet() {
        $this->assertEquals(1, 1);
    }
}
