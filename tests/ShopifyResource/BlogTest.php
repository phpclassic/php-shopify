<?php

namespace PHPShopify\ShopifyResource;

use PHPShopify\TestSimpleResource;

class BlogTest extends TestSimpleResource
{
    public $postArray = [
        "title" => "PHPShopify Test Blog",
    ];
    public $putArray = [
        "title" => "PHPShopify Test Blog Modified",
    ];
}
