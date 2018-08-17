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
        "address" => "https://whatever.phpclassic.com/",
        "format" => "json"
    );

    /**
     * @inheritDoc
     */
    public $putArray = array(
        "address" => "https://whatsoever.phpclassic.com/",
    );
}
