<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/10/16 10:46 AM UTC+06:00
 */

namespace PHPShopify;


class CustomerSavedSearchTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = array(
        "name" => "Spent more than $50 and after 2015",
        "query" => "total_spent:>50 order_date:>=2015-01-01",
    );

    /**
     * @inheritDoc
     */
    public $putArray = array(
        "name" => "This Name Has Been Changed",
    );
}