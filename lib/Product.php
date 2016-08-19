<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/18/16
 * Time: 10:46 AM
 */

namespace PHPShopify;


class Product extends ShopifyAPI
{
    public $resourceKey = 'product';
    public $childResource = array(
        'ProductImage' => 'Image',
        'ProductVariant' => 'Variant',
        'Metafield',
    );
}