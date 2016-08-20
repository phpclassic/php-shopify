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
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'customer_saved_search';

    /**
     * List of child Resource names / classes
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = array(
        'Customer',
    );

    /**
     * Get the pluralized version of the resource key
     *
     * @return string
     */
    protected function pluralizeKey()
    {
        return 'customer_saved_searches';
    }
}