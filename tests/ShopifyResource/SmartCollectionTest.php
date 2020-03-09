<?php

namespace PHPShopify;

class SmartCollectionTest extends TestSimpleResource
{
    public $postArray = [
        "title" => "McBooks",
        "published" => false,
        "rules"=> [
            [
                "column" => "vendor",
                "relation" => "equals",
                "condition" => "Coconut",
            ]
        ],
    ];

    /**
     * @inheritDoc
     */
    public $putArray = [
        "body_html" => "<p>The most expensive McBook ever.</p>",
    ];
}