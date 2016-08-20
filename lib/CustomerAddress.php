<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 12:07 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/customeraddress Shopify API Reference for CustomerAddress
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * CustomerAddress -> Custom actions
 * --------------------------------------------------------------------------
 * @method array makeDefault()      Sets the address as default for the customer
 * @method array set($params)       Perform bulk operations against a number of addresses
 *
 */
class CustomerAddress extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'address';

    /**
     * List of custom PUT actions
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name and key will be the associated path to be used with the action.
     *
     * @var array
     */
    protected $customPutActions = array(
        'default' => 'makeDefault',
    );

    /**
     * Get the pluralized version of the resource key
     *
     * @return string
     */
    protected function pluralizeKey()
    {
        return 'addresses';
    }


    //TODO Fix Issue (Api Error) : Internal server error
    public function set($params)
    {
        $url = $this->apiUrl . '/' . $this->id . '/set.json?' . http_build_query($params);
        return $this->put(array(), $url);
    }
}