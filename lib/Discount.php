<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 2:28 PM
 */

namespace PHPShopify;


class Discount extends ShopifyAPI
{
    protected $resourceKey = 'discount';
    protected $customPostActions = array(
        'enable',
        'disable',
    );
}