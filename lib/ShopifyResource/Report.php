<?php

namespace PHPShopify;

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