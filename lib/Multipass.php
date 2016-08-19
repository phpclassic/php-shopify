<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 6:05 PM
 */

namespace PHPShopify;


use PHPShopify\Exception\ApiException;

class Multipass extends ShopifyAPI
{

    public function __construct($config, $id = null)
    {
        throw new ApiException("Multipass API is not available yet!");
    }
}