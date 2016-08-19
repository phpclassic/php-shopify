<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 10:42 AM
 */

namespace PHPShopify;


class Shop extends ShopifyAPI
{
    protected $resourceKey = 'shop';
    protected $readOnly = true;

    public function pluralizeKey()
    {
        //Only one shop object for each store. So no pluralize
        return 'shop';
    }
}