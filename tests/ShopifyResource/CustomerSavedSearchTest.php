<?php

namespace PHPShopify\ShopifyResource;

use PHPShopify\TestSimpleResource;

class CustomerSavedSearchTest extends TestSimpleResource {
    public $postArray = [
        "name" => "Spent more than $50 and after 2015",
        "query" => "total_spent:>50 order_date:>=2015-01-01"
    ];
    public $putArray = [
        "name" => "This Name Has Been Changed"
    ];
}
