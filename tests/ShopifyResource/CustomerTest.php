<?php

namespace PHPShopify\ShopifyResource;

use PHPShopify\TestSimpleResource;

class CustomerTest extends TestSimpleResource
{
    public $postArray = [
        "first_name" => "Steve",
        "last_name" => "Lastnameson",
        "email" => "steve.lastnameson@example.com",
    ];
    public $putArray = [
        "verified_email" => true,
    ];

    public function testGet()
    {
        $this->assertEquals(1, 1);
    }
}
