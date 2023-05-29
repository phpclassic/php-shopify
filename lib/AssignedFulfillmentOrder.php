<?php
/**
 *
 * @see https://shopify.dev/docs/api/admin-rest/2023-04/resources/assignedfulfillmentorder Shopify API Reference for Assigned Fulfillment Order
 */

namespace PHPShopify;


class AssignedFulfillmentOrder extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'assigned_fulfillment_order';
}