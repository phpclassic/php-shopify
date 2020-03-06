<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 5:47 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/location Shopify API Reference for Location
 */

namespace PHPShopify;


class Location extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'location';

    /**
     * @inheritDoc
     */
    public $countEnabled = false;

    /**
     * @inheritDoc
     */
    public $readOnly = true;

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'InventoryLevel',
    );
}