<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 6:30 PM
 */

namespace PHPShopify;


class RecurringApplicationCharge extends ShopifyAPI
{
    protected $resourceKey = 'recurring_application_charge';
    protected $childResource = array(
        'UsageCharge',
    );

    protected $customPostActions = array(
        'activate',
    );

    //TODO PUT action
    public function customize($params) {

    }
}