<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/18/16 9:50 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/applicationcharge Shopify API Reference for ApplicationCharge
 */

namespace PHPShopify;


class ApplicationCredit extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'application_credit';

    /**
     * @inheritDoc
     */
    public $countEnabled = false;


}
