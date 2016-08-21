<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 7:40 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/smartcollection Shopify API Reference for SmartCollection
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * SmartCollection -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read ShopifyAPI $Event
 *
 * @method ShopifyAPI Event(integer $id = null)
 *
 * --------------------------------------------------------------------------
 * SmartCollection -> Custom actions
 * --------------------------------------------------------------------------
 * @method array sortOrder($params)     Set the ordering type and/or the manual order of products in a smart collection
 *
 */
class SmartCollection extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'smart_collection';

    /**
     * List of child Resource names / classes
     * If any array item has an associative key => value pair, value will be considered as the resource name
     * (by which it will be called) and key will be the associated class name.
     *
     * @var array
     */
    protected $childResource = array(
        'Event',
    );

    /**
     * Set the ordering type and/or the manual order of products in a smart collection
     *
     * @param array $params
     *
     * @return array
     */
    public function sortOrder($params) {
        $url = $this->generateUrl($params, 'order');

        return $this->put(array(), $url);
    }
}