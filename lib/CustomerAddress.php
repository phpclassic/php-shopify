<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 12:07 PM
 */

namespace PHPShopify;


class CustomerAddress extends ShopifyAPI
{
    protected $resourceKey = 'address';
    protected $customPutActions = array(
        'default' => 'makeDefault',
    );

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