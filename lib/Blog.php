<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/18/16
 * Time: 10:46 AM
 */

namespace PHPShopify;


class Blog extends ShopifyAPI
{
    public $resourceKey = 'blog';
    public $childResource = array(
        'Article',
    );
}