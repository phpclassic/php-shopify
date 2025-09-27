<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 11:47 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/customer Shopify API Reference for Customer
 */

namespace PHPShopify;


/**
 * --------------------------------------------------------------------------
 * Customer -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read CustomerAddress $Address
 * @property-read Metafield $Metafield
 *
 * @method CustomerAddress Address(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 * --------------------------------------------------------------------------
 * Customer -> Custom actions
 * --------------------------------------------------------------------------
 * @method array search(string $query = '')      Search for customers matching supplied query
 */
class Customer extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey ='customer';

    /**
     * @inheritDoc
     */
    public $searchEnabled = true;

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'CustomerAddress' => 'Address',
        'Metafield',
        'Order'
    );

    /**
     * Sends an account invite to a customer.
     *
     * @param array $customer_invite Customized invite data
     *
     * @return array
     */
    public function send_invite($customer_invite = array())
    {
        if (empty ( $customer_invite ) ) $customer_invite = new \stdClass();
        $url = $this->generateUrl(array(), 'send_invite');
        $dataArray = $this->wrapData($customer_invite, 'customer_invite');

        return $this->post($dataArray, $url, false);
    }

    /**
     * Create account_activation_link for customer.
     *
     * @param array $customer_id
     *
     * @return array
     */
    public function account_activation_url($customer_id = 0)
    {
        if (!(int)$customer_id > 0) {
            return false;
        }

        $url = $this->generateUrl(array(), $customer_id.'/account_activation_url');
        return $this->post(array(), $url, false);
    }
}
