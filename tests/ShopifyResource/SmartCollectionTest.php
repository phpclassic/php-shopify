<?php

namespace PHPShopify\ShopifyResource;

use PHPShopify\TestSimpleResource;

class SmartCollectionTest extends TestSimpleResource {
    public $postArray = [
        "title" => "McBooks",
        "published" => false,
        "rules"=> [
            [
                "column" => "vendor",
                "relation" => "equals",
                "condition" => "Coconut"
            ]
        ]
    ];
    public $putArray = [
        "body_html" => "<p>The most expensive McBook ever.</p>"
    ];
}
