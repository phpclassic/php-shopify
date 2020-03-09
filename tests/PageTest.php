<?php

namespace PHPShopify;

class PageTest extends TestSimpleResource
{
    public $postArray = [
        "title" => "Warranty information",
        "body_html" => "<h1>Warranty</h1>\n<p><strong>Forget it</strong>, we ain't giving you nothing</p>",
    ];
    public $putArray = [
        "title" => "Updated Warranty information"
    ];
}
