<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 8/21/16 8:39 AM UTC+06:00
 *
 * @see https://shopify.dev/docs/api/admin-rest/2023-01/resources/gift-card-adjustment Shopify API Reference for Gift Card Adjustment
 * @note - requires gift_card_adjustments access scope enabled by Shopify Support
 *
 * @usage: 
 *
    $shopify = \PHPShopify\ShopifySDK::config($config);

    $gift_card_id = 88888888888;

    $gift_card_adjustment_id = 999999999999;

    // Get all gift card adjustments
    $shopify->GiftCard($gift_card_id)->Adjustment()->get();

    // Get a single gift card adjustment
    $shopify->GiftCard($gift_card_id)->Adjustment($gift_card_adjustment_id)->get();

    // Create a gift card adjustment
    $shopify->GiftCard($gift_card_id)->Adjustment()->post([
        'amount' => 5,
        'note' => 'Add $5 to gift card'
    ]);
 */

namespace PHPShopify;


class GiftCardAdjustment extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'adjustment';
}
