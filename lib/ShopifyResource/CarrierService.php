<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 10:49 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/carrierservice Shopify API Reference for CarrierService
 */

namespace PHPShopify;


class CarrierService extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'carrier_service';

    /**
     * @inheritDoc
     */
    public $countEnabled = false;
}