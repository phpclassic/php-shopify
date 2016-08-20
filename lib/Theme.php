<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/18/16 10:46 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/theme Shopify API Reference for Theme
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * Theme -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyAPI $Asset
 *
 * @method ShopifyAPI Asset(integer $id = null)
 *
 */
class Theme extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    public $resourceKey = 'theme';

    /**
     * List of child Resource names / classes
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = array(
        'Asset'
    );
}