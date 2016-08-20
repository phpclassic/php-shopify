<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/17/16 10:39 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/page Shopify API Reference for Page
 */

namespace PHPShopify;


class Page extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'page';
}