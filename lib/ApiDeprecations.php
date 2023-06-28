<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * @author Steve Barbera <whobutsb@gmail.com>
 * Created at 8/18/16 3:39 PM UTC+06:00
 *
 * @see https://shopify.dev/api/admin-rest/2022-04/resources/deprecated-api-calls#get-deprecated-api-calls Shopify API Reference for API Deprecations
 */

namespace PHPShopify;


class ApiDeprecations extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'deprecated_api_calls';

    /**
     * @inheritDoc
     */
    public $readOnly = true;

    /**
     * @inheritDoc
     */
    public $countEnabled = false;

    /**
     * @inheritDoc
     */
    public function pluralizeKey()
    {
        //Only api deprecations, so no pluralize
        return 'deprecated_api_calls';
    }
}
