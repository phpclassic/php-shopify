<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 11:44 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/country Shopify API Reference for Country
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * Country -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyAPI $Province
 *
 * @method ShopifyAPI Province(integer $id = null)
 *
 */
class Country extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'country';

    /**
     * List of child Resource names / classes
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = array(
        'Province',
    );

    /**
     * Get the pluralized version of the resource key
     *
     * @return string
     */
    protected function pluralizeKey()
    {
        return 'countries';
    }
}