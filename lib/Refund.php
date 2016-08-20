<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 7:19 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/refund Shopify API Reference for Refund
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * Refund -> Custom actions
 * --------------------------------------------------------------------------
 * @method array calculate()      Calculate a Refund.
 *
 */
class Refund extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'refund';

    /**
     * List of custom POST actions
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name and key will be the associated path to be used with the action.
     *
     * @var array
     */
    protected $customPostActions = array (
        'calculate',
    );
}