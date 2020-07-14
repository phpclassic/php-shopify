<?php

namespace PHPShopify;


class Transactions extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'transaction';

    /**
     * If the resource is read only. (No POST / PUT / DELETE actions)
     *
     * @var boolean
     */
    public $readOnly = true;
}
