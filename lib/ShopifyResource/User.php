<?php
/**
 * @see https://help.shopify.com/api/reference/user Shopify API Reference for User
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * --------------------------------------------------------------------------
 * User -> Custom actions
 * --------------------------------------------------------------------------
 * @method array current()      Get the current logged-in user
 */
class User extends ShopifyResource
{
    protected $resourceKey = 'user';
    public $readOnly = true;

    protected $customGetActions = [
      'current',
    ];
}
