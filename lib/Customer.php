<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 11:47 AM
 */

namespace PHPShopify;


class Customer extends ShopifyAPI
{
    protected $resourceKey ='customer';
    protected $searchEnabled = true;
    public $childResource = array('CustomerAddress' => 'Address');
}