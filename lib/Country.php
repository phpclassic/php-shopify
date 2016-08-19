<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 11:44 AM
 */

namespace PHPShopify;


class Country extends ShopifyAPI
{
    protected $resourceKey = 'country';
    protected $childResource = array(
        'Province',
    );

    protected function pluralizeKey()
    {
        return 'countries';
    }
}