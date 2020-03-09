<?php
/**
 * @see https://help.shopify.com/api/reference/draftorder
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @method array send_invoice()     Send the invoice for a DraftOrder
 * @method array complete()         Complete a DraftOrder
 */
class DraftOrder extends ShopifyResource {
    protected $resourceKey = 'draft_order';
    protected $customPostActions = [
        'send_invoice'
    ];
    protected $customPutActions = [
        'complete'
    ];
}
