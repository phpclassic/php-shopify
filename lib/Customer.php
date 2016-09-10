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
 * @property-read ShopifyResource $Address
 * @property-read ShopifyResource $Metafield
 *
 * @method ShopifyResource Address(integer $id = null)
 * @method ShopifyResource Metafield(integer $id = null)
 * --------------------------------------------------------------------------
 * Customer -> Custom actions
 * --------------------------------------------------------------------------
 * @method array search()      Search for customers matching supplied query
 */
class Customer extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey ='customer';

    /**
     * @inheritDoc
     */
    public $searchEnabled = true;

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'CustomerAddress' => 'Address',
        'Metafield',
    );
}