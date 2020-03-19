<?php
/**
 * @see https://help.shopify.com/api/reference/article
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Event $Event
 * @property-read Metafield $Metafield
 * @method Event Event(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 */
class Article extends ShopifyResource {
    protected $resourceKey = 'article';
    protected $childResource = [
        'Event',
        'Metafield'
    ];
}
