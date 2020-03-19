<?php
/**
 * @see https://help.shopify.com/api/reference/blog
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Article $Article
 * @property-read Event $Event
 * @property-read Metafield $Metafield
 * @method Article Article(integer $id = null)
 * @method Event Event(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 */
class Blog extends ShopifyResource {
    public $resourceKey = 'blog';
    protected $childResource = [
        'Article',
        'Event',
        'Metafield'
    ];
}
