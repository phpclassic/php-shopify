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
 * @property-read ShopifyResource $Article
 * @property-read ShopifyResource $Event
 * @property-read ShopifyResource $Metafield
 *
 * @method ShopifyResource Article(integer $id = null)
 * @method ShopifyResource Event(integer $id = null)
 * @method ShopifyResource Metafield(integer $id = null)
 *
 */
class Blog extends ShopifyResource
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