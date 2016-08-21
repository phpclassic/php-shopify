<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/18/16 10:46 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/blog Shopify API Reference for Blog
 */

namespace PHPShopify;

/*
 * --------------------------------------------------------------------------
 * Blog -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyAPI $Article
 * @property-read ShopifyAPI $Event
 *
 * @method ShopifyAPI Article(integer $id = null)
 * @method ShopifyAPI Event(integer $id = null)
 *
 */
class Blog extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    public $resourceKey = 'blog';

    /**
     * List of child Resource names / classes
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = array(
        'Article',
        'Event',
    );
}