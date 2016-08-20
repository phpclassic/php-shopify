<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 11:46 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/customcollection Shopify API Reference for CustomCollection
 */

namespace PHPShopify;


class CustomCollection extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'custom_collection';
}