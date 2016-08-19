<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 2:59 PM
 */

namespace PHPShopify;


class Order extends ShopifyAPI
{
    protected $resourceKey = 'order';
    protected $childResource = array (
        'Fulfillment',
        'OrderRisk' => 'Risk',
        'Refund',
        'Transaction',
    );
}