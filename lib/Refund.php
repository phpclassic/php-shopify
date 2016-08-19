<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 7:19 PM
 */

namespace PHPShopify;


class Refund extends ShopifyAPI
{
    protected $resourceKey = 'refund';

    protected $customPostActions = array (
        'calculate',
    );
}