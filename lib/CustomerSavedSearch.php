<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 2:07 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/customersavedsearch Shopify API Reference for CustomerSavedSearch
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * CustomerSavedSearch -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyAPI $Customer
 *
 * @method ShopifyAPI Customer(integer $id = null)
 *
 */
class CustomerSavedSearch extends ShopifyAPI
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'customer_saved_search';

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'Customer',
    );

    /**
     * @inheritDoc
     */
    protected function pluralizeKey()
    {
        return 'customer_saved_searches';
    }
}