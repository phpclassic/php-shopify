<?php
/**
 *
 * @see https://help.shopify.com/api/reference/fulfillmentservice Shopify API Reference for FulfillmentService
 */

namespace PHPShopify;

/**
 * --------------------------------------------------------------------------
 * CancellationRequest -> Child Resources
 * --------------------------------------------------------------------------
 *
 * --------------------------------------------------------------------------
 * CancellationRequest -> Custom actions
 * --------------------------------------------------------------------------
 * @method array accept()     Accept a fulfilment order
 * @method array reject()     Rejects a fulfillment order
 */
class CancellationRequest extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'cancellation_request';

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
