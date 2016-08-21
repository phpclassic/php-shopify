<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 5:35 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/gift_card Shopify API Reference for GiftCard
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * GiftCard -> Custom actions
 * --------------------------------------------------------------------------
 * @method array disable()      Disable a gift card. Disabling a gift card is permanent and cannot be undone.
 *
 */
class GiftCard extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'gift_card';

    /**
     * If search is enabled for the resource
     *
     * @var boolean
     */
    protected $searchEnabled = true;

    /**
     * Disable a gift card.
     * Disabling a gift card is permanent and cannot be undone.
     *
     * @return array
     */
    public function disable() {
        $url = $this->generateUrl(array(), 'disable');

        $dataArray = array(
            'id' => $this->id,
        );

        return $this->post($dataArray, $url);
    }
}