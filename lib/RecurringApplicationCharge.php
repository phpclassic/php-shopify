<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 6:30 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/recurringapplicationcharge Shopify API Reference for RecurringApplicationCharge
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * RecurringApplicationCharge -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyAPI $UsageCharge
 *
 * @method ShopifyAPI UsageCharge(integer $id = null)
 *
 * --------------------------------------------------------------------------
 * RecurringApplicationCharge -> Custom actions
 * --------------------------------------------------------------------------
 * @method array activate()             Activate a recurring application charge
 * @method array customize($data)     Customize a recurring application charge
 *
 */
class RecurringApplicationCharge extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'recurring_application_charge';

    /**
     * List of child Resource names / classes
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = array(
        'UsageCharge',
    );

    /**
     * List of custom POST actions
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name and key will be the associated path to be used with the action.
     *
     * @var array
     */
    protected $customPostActions = array(
        'activate',
    );

    /*
     * Customize a recurring application charge
     *
     * @param array $data
     *
     * @return array
     *
     */
    public function customize($data) {
        $data = $this->wrapData($data);

        $url = $this->generateUrl($data, 'customize');

        return $this->put(array(), $url);
    }
}