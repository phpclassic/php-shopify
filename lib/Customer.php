<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 11:47 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/customer Shopify API Reference for Customer
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * Customer -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyAPI $Address
 * @property-read ShopifyAPI $Metafield
 *
 * @method ShopifyAPI Address(integer $id = null)
 * @method ShopifyAPI Metafield(integer $id = null)
 * --------------------------------------------------------------------------
 * Customer -> Custom actions
 * --------------------------------------------------------------------------
 * @method array search()      Search for customers matching supplied query
 */
class Customer extends ShopifyAPI
{
    /**
     * @inheritDoc
     */
    protected $resourceKey ='customer';

    /**
     * @inheritDoc
     */
    protected $searchEnabled = true;

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'CustomerAddress' => 'Address',
        'Metafield',
    );
}