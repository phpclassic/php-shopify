<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/18/16 3:18 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/article Shopify API Reference for Article
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * Article -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyAPI $Event
 *
 * @method ShopifyAPI Event(integer $id = null)
 *
 */
class Article extends ShopifyAPI
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'article';

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'Event',
    );
}