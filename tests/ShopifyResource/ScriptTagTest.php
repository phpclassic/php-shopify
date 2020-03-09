<?php

namespace PHPShopify;

class ScriptTagTest extends TestSimpleResource
{
    public $postArray = [
        "event" => "onload",
        "src" => "https://djavaskripped.org/fancy.js",
    ];

    public $putArray = [
        "src" => "https://somewhere-else.com/another.js",
    ];
}
