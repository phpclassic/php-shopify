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
 * @property-read ShopifyAPI $Metafield
 *
 * @method ShopifyAPI Article(integer $id = null)
 * @method ShopifyAPI Event(integer $id = null)
 * @method ShopifyAPI Metafield(integer $id = null)
 *
 */
class Blog extends ShopifyAPI
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'blog';

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'Article',
        'Event',
        'Metafield',
    );
}