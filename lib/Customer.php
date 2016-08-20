<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 11:47 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/customer Shopify API Reference for Customer
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * Customer -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyAPI $Address
 *
 * @method ShopifyAPI Address(integer $id = null)
 *
 */
class Customer extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey ='customer';

    /**
     * If search is enabled for the resource
     *
     * @var boolean
     */
    protected $searchEnabled = true;

    /**
     * List of child Resource names / classes
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = array(
        'CustomerAddress' => 'Address'
    );
}