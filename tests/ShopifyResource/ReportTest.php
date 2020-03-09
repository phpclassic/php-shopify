<?php

namespace PHPShopify\ShopifyResource;

use PHPShopify\TestSimpleResource;

class ReportTest extends TestSimpleResource
{
    public $postArray = [
        "name" => "A new app report",
        "shopify_ql" => "SHOW total_sales BY country FROM order SINCE -1m UNTIL today ORDER BY total_sales",
    ];

    public $putArray = [
        "name" => "A new app report - updated",
    ];
}
