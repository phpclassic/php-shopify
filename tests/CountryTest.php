<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/10/16 10:45 AM UTC+06:00
 */

namespace PHPShopify;


class CountryTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = array(
        "code" => "FR",
        "tax" => 0.25,
    );

    /**
     * @inheritDoc
     */
    public $putArray = array(
        "tax" => 0.01,
    );
}