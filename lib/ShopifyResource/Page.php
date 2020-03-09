<?php
/**
 * @see https://help.shopify.com/api/reference/page
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Event $Event
 * @property-read Metafield $Metafield
 * @method Event Event(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 */
class Page extends ShopifyResource {
    protected $resourceKey = 'page';
    protected $childResource = [
        'Event',
        'Metafield'
    ];
}
