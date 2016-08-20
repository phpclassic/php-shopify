<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 5:35 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/gift_card Shopify API Reference for GiftCard
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * GiftCard -> Custom actions
 * --------------------------------------------------------------------------
 * @method array disable()      Disable a gift card. Disabling a gift card is permanent and cannot be undone.
 *
 */
class GiftCard extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'gift_card';

    /**
     * If search is enabled for the resource
     *
     * @var boolean
     */
    protected $searchEnabled = true;

    /**
     * List of custom POST actions
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name and key will be the associated path to be used with the action.
     *
     * @var array
     */
    protected $customPostActions = array(
        'disable',
    );
}