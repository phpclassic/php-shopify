<?php

namespace PHPShopify;

class MetafieldTest extends TestSimpleResource
{
    public $postArray = [
        "namespace" => "inventory",
        "key" => "warehouse",
        "value" => 25,
        "value_type" => "integer",
    ];

    public $putArray = [
        "value" => "something new",
        "value_type" => "string",
    ];
}
