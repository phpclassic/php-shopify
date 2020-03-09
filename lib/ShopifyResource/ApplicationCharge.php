<?php
/**
 * @see https://help.shopify.com/api/reference/applicationcharge Shopify API Reference for ApplicationCharge
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class ApplicationCharge extends ShopifyResource {
    protected $resourceKey = 'application_charge';
    public $countEnabled = false;
    protected $customPostActions = [
       'activate'
    ];
}
