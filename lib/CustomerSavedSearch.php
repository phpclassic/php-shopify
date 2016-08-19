<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 2:07 PM
 */

namespace PHPShopify;


class CustomerSavedSearch extends ShopifyAPI
{
    protected $resourceKey = 'customer_saved_search';
    protected $childResource = array(
        'Customer',
    );

    protected function pluralizeKey()
    {
        return 'customer_saved_searches';
    }
}