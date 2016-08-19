<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 8:00 PM
 */

namespace PHPShopify;


class User extends ShopifyAPI
{
    protected $resourceKey = 'user';
    protected $readOnly = true;
    protected $customGetActions = array (
      'current'
    );
}