<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/10/16 10:52 AM UTC+06:00
 */

namespace PHPShopify;


class WebhookTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = array(
        "topic" => "orders/create",
        "address" => "http://whatever.phpclassic.com/",
        "format" => "json"
    );

    /**
     * @inheritDoc
     */
    public $putArray = array(
        "address" => "http://whatsoever.phpclassic.com/",
    );
}