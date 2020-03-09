<?php

namespace PHPShopify;

class CustomCollectionTest extends TestSimpleResource
{
    public $postArray = [
        "title" => "Macbooks",
    ];
    public $putArray = [
        "title" => "Updated - Macbooks",
        "body_html" => "<p>The best selling Macbooks ever</p>",
    ];
}
