<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 6:30 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/recurringapplicationcharge Shopify API Reference for RecurringApplicationCharge
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * RecurringApplicationCharge -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read UsageCharge $UsageCharge
 *
 * @method UsageCharge UsageCharge(integer $id = null)
 *
 * --------------------------------------------------------------------------
 * RecurringApplicationCharge -> Custom actions
 * --------------------------------------------------------------------------
 * @method array activate()             Activate a recurring application charge
 *
 */
class RecurringApplicationCharge extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'recurring_application_charge';

    /**
     * @inheritDoc
     */
    public $countEnabled = false;

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'UsageCharge',
    );

    /**
     * @inheritDoc
     */
    protected $customPostActions = array(
        'activate',
    );

    /*
     * Create a recurring application charge
     *
     * @param array $data
     *
     * @return array
     *
     */
    public function create($dataArray)
    {
        $dataArray = $this->wrapData($dataArray);

        $url = $this->generateUrl($dataArray);

        $response = $this->post(array(), $url);

        return $response;
    }

    /**
     * Get list of all charges
     * 
     * @return array
     */
    public function charges(){
        $url = $this->generateUrl();

        $response = $this->get(array(), $url);

        return $response;
    }

    /**
     * Get details of a single charge
     * 
     * @param $charge_id
     * 
     * @return array
     */
    public function charge( $charge_id ){
        $url = $this->generateUrl(array(), $charge_id);

        $response = $this->get(array(), $url);

        return $response;
    }

    /**
     * Cancel a recurring charge
     * 
     * @param $charge_id
     * 
     * @return array
     */
    public function cancel($charge_id){
        $url = $this->generateUrl(array(), $charge_id);

        $response = $this->delete(array(), $url);

        return $response;
    }

    /*
     * Customize a recurring application charge
     *
     * @param array $data
     *
     * @return array
     *
     */
    public function customize($dataArray)
    {
        $dataArray = $this->wrapData($dataArray);

        $url = $this->generateUrl($dataArray, 'customize');

        return $this->put(array(), $url);
    }
}