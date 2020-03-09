<?php
/**
 * @see https://help.shopify.com/api/reference/gift_card Shopify API Reference for GiftCard
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @method array search()       Search for gift cards matching supplied query
 */
class GiftCard extends ShopifyResource {
    protected $resourceKey = 'gift_card';
    public $searchEnabled = true;

    /**
     * Disable a gift card.
     * Disabling a gift card is permanent and cannot be undone.
     */
    public function disable(): array {
        $url = $this->generateUrl([], 'disable');

        $dataArray = [
            'id' => $this->id
        ];

        return $this->post($dataArray, $url);
    }
}
