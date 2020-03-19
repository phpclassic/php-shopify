<?php

namespace PHPShopify\ShopifyResource;

use PHPShopify\TestSimpleResource;

class WebhookTest extends TestSimpleResource {
    public $postArray = [
        "topic" => "orders/create",
        "address" => "https://whatever.phpclassic.com/",
        "format" => "json"
    ];
    public $putArray = [
        "address" => "https://whatsoever.phpclassic.com/"
    ];
}
