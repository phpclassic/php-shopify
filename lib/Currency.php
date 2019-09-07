<?php
/**
 * Created by PhpStorm.
 * User: Tareq
 * Date: 6/10/2019
 * Time: 11:22 PM
 *
 * @see https://help.shopify.com/en/api/reference/store-properties/currency Shopify API Reference for Currency
 */

namespace PHPShopify;


class Currency extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'currency';

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
        return 'currencies';
    }
}