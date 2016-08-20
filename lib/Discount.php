<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 2:28 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/discount Shopify API Reference for Discount
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * Discount -> Custom actions
 * --------------------------------------------------------------------------
 * @method array enable()       Enable a discount
 * @method array disable()      Disable a discount
 *
 */
class Discount extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'discount';

    /**
     * List of custom POST actions
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name and key will be the associated path to be used with the action.
     *
     * @var array
     */
    protected $customPostActions = array(
        'enable',
        'disable',
    );
}