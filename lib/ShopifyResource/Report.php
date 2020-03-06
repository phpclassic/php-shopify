<?php

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

class Report extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'report';

    /**
     * @inheritDoc
     */
    public $countEnabled = false;
}