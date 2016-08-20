<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 7:40 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/smartcollection Shopify API Reference for SmartCollection
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * SmartCollection -> Custom actions
 * --------------------------------------------------------------------------
 * @method array order($params)     Set the ordering type and/or the manual order of products in a smart collection
 *
 */
class SmartCollection extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'smart_collection';

    //TODO PUT action
    public function order($params) {

    }
}