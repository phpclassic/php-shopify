<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 6:22 PM
 */

namespace PHPShopify;


class Policy extends ShopifyAPI
{
    protected $resourceKey = 'policy';
    protected $readOnly = true;

    public function pluralizeKey()
    {
        return 'policies';
    }
}