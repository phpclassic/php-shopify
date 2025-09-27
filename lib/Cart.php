<?php

namespace PHPShopify;

/* @see https://shopify.dev/docs/themes/ajax-api/reference/cart */
use PHPShopify\ShopifyResource;

class Cart extends ShopifyResource {

     /**
     * @inheritDoc
     */
    protected $resourceKey ='cart';

     /**
     * @inheritDoc
     */
    public $searchEnabled = false;

     /**
     * @inheritDoc
     */
    public $readOnly = true;
}
