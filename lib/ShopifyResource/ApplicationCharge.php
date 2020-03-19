<?php
/**
 * @see https://help.shopify.com/api/reference/applicationcharge
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
