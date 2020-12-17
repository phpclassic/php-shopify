<?php

namespace PHPShopify;

class TenderTransaction extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'tender_transaction';

    /**
     * If the resource is read only. (No POST / PUT / DELETE actions)
     *
     * @var boolean
     */
    public $readOnly = true;
}
