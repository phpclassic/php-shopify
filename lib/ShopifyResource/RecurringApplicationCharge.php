<?php
/**
 * @see https://help.shopify.com/api/reference/recurringapplicationcharge Shopify API Reference for RecurringApplicationCharge
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read UsageCharge $UsageCharge
 * @method UsageCharge UsageCharge(integer $id = null)
 * @method array activate()             Activate a recurring application charge
 */
class RecurringApplicationCharge extends ShopifyResource {
    protected $resourceKey = 'recurring_application_charge';
    public $countEnabled = false;
    protected $childResource = [
        'UsageCharge'
    ];
    protected $customPostActions = [
        'activate'
    ];

    public function customize(array $dataArray): array {
        $dataArray = $this->wrapData($dataArray);

        $url = $this->generateUrl($dataArray, 'customize');

        return $this->put([], $url);
    }
}
