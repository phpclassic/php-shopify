<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/18/16 3:18 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/article Shopify API Reference for Article
 */

namespace PHPShopify;


class Article extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'article';
}