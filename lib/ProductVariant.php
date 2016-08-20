<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/18/16 1:50 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/product_variant Shopify API Reference for Product Variant
 */

namespace PHPShopify;


class ProductVariant extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'variant';
}