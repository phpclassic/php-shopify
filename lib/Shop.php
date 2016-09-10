<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 10:42 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/shop Shopify API Reference for Shop
 */

namespace PHPShopify;


class Shop extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'shop';

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
    public function pluralizeKey()
    {
        //Only one shop object for each store. So no pluralize
        return 'shop';
    }
}