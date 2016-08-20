<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 10:42 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/shop Shopify API Reference for Shop
 */

namespace PHPShopify;


class Shop extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'shop';

    /**
     * If the resource is read only. (No POST / PUT / DELETE actions)
     *
     * @var boolean
     */
    public $readOnly = true;

    /**
     * Get the pluralized version of the resource key
     *
     * @return string
     */
    public function pluralizeKey()
    {
        //Only one shop object for each store. So no pluralize
        return 'shop';
    }
}