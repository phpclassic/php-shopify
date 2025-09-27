<?php

namespace PHPShopify;

/**
 * Class AccessScope
 * @package PHPShopify
 * @author Alexey Sinkevich
 */
class AccessScope extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'access_scope';

    /**
     * @inheritDoc
     */
    public $countEnabled = true;

    /**
     * @inheritDoc
     */
    public $readOnly = true;

    /**
     * @param array $urlParams
     * @param null $customAction
     * @return string
     */
    public function generateUrl($urlParams = array(), $customAction = null)
    {
        return ShopifySDK::$config['AdminUrl'] . 'oauth/' . $this->getResourcePath() . '.json';
    }
}
