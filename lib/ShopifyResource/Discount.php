<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 2:28 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/discount Shopify API Reference for Discount
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * Discount -> Custom actions
 * --------------------------------------------------------------------------
 * @method array enable()       Enable a discount
 * @method array disable()      Disable a discount
 *
 */
class Discount extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'discount';

    /**
     * @inheritDoc
     */
    protected $customPostActions = array(
        'enable',
        'disable',
    );
}