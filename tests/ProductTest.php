<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/9/16 12:44 PM UTC+06:00
 */

namespace PHPShopify;


class ProductTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = array(
        "title" => "Burton Custom Freestlye 151",
        "body_html" => "<strong>Good snowboard!</strong>",
        "vendor" => "Burton",
        "product_type" => "Snowboard",
        "variants" => [
            [
                "option1" => "First",
                "price" => "10.00",
                "sku" => 123
            ],
            [
                "option1" => "Second",
                "price" => "20.00",
                "sku" => "123"
            ]
        ]
    );

    /**
     * @inheritDoc
     * Posting without title, triggers an error
     */
    public $errorPostArray = array("description" => "A mystery!");

    /**
     * @inheritDoc
     */
    public $putArray = array("title" => "New product title");
}