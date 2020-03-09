<?php

namespace PHPShopify\ShopifyResource;

use PHPShopify\TestSimpleResource;

class BlogTest extends TestSimpleResource {
    public $postArray = [
        "title" => "Mega Test Blog"
    ];
    public $putArray = [
        "title" => "Mega Test Blog Modified"
    ];
}
