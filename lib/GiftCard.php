<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 5:35 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/gift_card Shopify API Reference for GiftCard
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * GiftCard -> Custom actions
 * --------------------------------------------------------------------------
 * @method array search()       Search for gift cards matching supplied query
 *
 */
class GiftCard extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'gift_card';

    /**
     * @inheritDoc
     */
    public $searchEnabled = true;

    /**
     * Disable a gift card.
     * Disabling a gift card is permanent and cannot be undone.
     *
     * @return array
     */
    public function disable()
    {
        $url = $this->generateUrl(array(), 'disable');

        $dataArray = array(
            'id' => $this->id,
        );

        return $this->post($dataArray, $url);
    }
}