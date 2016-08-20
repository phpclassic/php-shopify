<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 8:00 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/user Shopify API Reference for User
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * User -> Custom actions
 * --------------------------------------------------------------------------
 * @method array current()      Get the current logged-in user
 *
 */
class User extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'user';

    /**
     * If the resource is read only. (No POST / PUT / DELETE actions)
     *
     * @var boolean
     */
    public $readOnly = true;

    /**
     * List of custom GET actions
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name and key will be the associated path to be used with the action.
     *
     * @var array
     */
    protected $customGetActions = array (
      'current'
    );
}