<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/18/16
 * Time: 10:46 AM
 */

namespace PHPShopify;


class Theme extends ShopifyAPI
{
    public $resourceKey = 'theme';
    public $childResource = array(
        'Asset'
    );
}