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
     * @inheritDoc
     */
    protected $resourceKey = 'country';

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'Province',
    );

    /**
     * @inheritDoc
     */
    protected function pluralizeKey()
    {
        return 'countries';
    }
}