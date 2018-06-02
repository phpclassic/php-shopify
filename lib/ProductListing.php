<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 6/2/18 1:38 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/sales_channels/productlisting Shopify API Reference for Shipping Zone
 */

namespace PHPShopify;


class ProductListing extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'product_listing';

    /**
     * @inheritDoc
     */
    protected $customGetActions = array (
        'product_ids' => 'productIds',
    );
}