<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 6:22 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/policy Shopify API Reference for Policy
 */

namespace PHPShopify;


class Policy extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'policy';

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
        return 'policies';
    }
}