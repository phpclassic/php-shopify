<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 6/2/18 1:38 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/sales_channels/collectionlisting
 */

namespace PHPShopify;
/**
 * --------------------------------------------------------------------------
 * CollectionListing -> Custom actions
 * --------------------------------------------------------------------------
 * @method array productIds()      Sets the address as default for the customer
 */

class CollectionListing extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'collection_listing';

    /**
     * @inheritDoc
     */
    protected $customGetActions = array(
        'product_ids' => 'productIds',
    );

}
