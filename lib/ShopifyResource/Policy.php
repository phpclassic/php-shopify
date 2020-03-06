<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 6:22 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/policy Shopify API Reference for Policy
 */

namespace PHPShopify;


class Policy extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'policy';

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
        return 'policies';
    }
}