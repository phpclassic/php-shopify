<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 8:00 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/user Shopify API Reference for User
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * User -> Custom actions
 * --------------------------------------------------------------------------
 * @method array current()      Get the current logged-in user
 *
 */
class User extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'user';

    /**
     * @inheritDoc
     */
    public $readOnly = true;

    /**
     * @inheritDoc
     */
    protected $customGetActions = array (
      'current'
    );
}