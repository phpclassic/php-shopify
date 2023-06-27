<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 8/21/16 8:39 AM UTC+06:00
 *
 * @see https://shopify.dev/docs/api/admin-rest/2023-01/resources/gift-card-adjustment Shopify API Reference for Gift Card Adjustment
 * @note - requires gift_card_adjustments access scope enabled by Shopify Support
 */

namespace PHPShopify;


class GiftCardAdjustment extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'adjustment';
}
