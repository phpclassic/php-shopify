<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 5:28 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/fulfillmentservice Shopify API Reference for FulfillmentService
 */

namespace PHPShopify;

/**
 * --------------------------------------------------------------------------
 * FulfillmentRequest -> Child Resources
 * --------------------------------------------------------------------------
 *
 * --------------------------------------------------------------------------
 * FulfillmentRequest -> Custom actions
 * --------------------------------------------------------------------------
 * @method array accept()     Accept a fulfilment order
 * @method array reject()     Rejects a fulfillment order
 */
class FulfillmentRequest extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'fulfillment_request';

    /**
     * @inheritDoc
     */
    public $countEnabled = false;

    /**
     * @inheritDoc
     */
    protected $customPostActions = array(
        'accept',
        'reject'
    );

    protected function pluralizeKey()
    {
        return $this->resourceKey;
    }
}