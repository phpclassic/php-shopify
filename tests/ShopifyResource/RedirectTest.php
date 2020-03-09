<?php

namespace PHPShopify;

class RedirectTest extends TestSimpleResource
{
    public $postArray = [
        "path" => "http://www.apple.com/forums",
        "target" => "http://forums.apple.com",
    ];

    public $putArray = [
        "path" => "/tiger",
    ];
}