<?php
/**
 * @see https://help.shopify.com/api/reference/smartcollection Shopify API Reference for SmartCollection
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Event $Event
 * @method Event Event(integer $id = null)
 */
class SmartCollection extends ShopifyResource
{
    protected $resourceKey = 'smart_collection';
    protected $childResource = [
        'Event',
        'Metafield',
    ];

    /**
     * Set the ordering type and/or the manual order of products in a smart collection
     */
    public function sortOrder(array $params): array
    {
        $url = $this->generateUrl($params, 'order');

        return $this->put([], $url);
    }
}
