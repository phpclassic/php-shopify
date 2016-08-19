<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 5:35 PM
 */

namespace PHPShopify;


class GiftCard extends ShopifyAPI
{
    protected $resourceKey = 'gift_card';
    protected $searchEnabled = true;

    protected $customPostActions = array(
        'disable',
    );
}