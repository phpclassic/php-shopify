<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 2:59 PM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/draftorder Shopify API Reference for DraftOrder
 */

namespace PHPShopify;



/**
 * --------------------------------------------------------------------------
 * DraftOrder -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read Metafield $Metafield
 *

 * @method Metafield Metafield(integer $id = null)
 *
 * --------------------------------------------------------------------------
 * DraftOrder -> Custom actions
 * --------------------------------------------------------------------------
 * @method array sendInvoice()     Sends an invoice for the order
 * @method array complete()         Completes Draft Order
 *
 */
class DraftOrder extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'draft_order';

    /**
     * @inheritDoc
     */
    protected $childResource = array (
        'Metafield',
    );

    /**
     * @inheritDoc
     */
    protected $customPostActions = array(
        'send_invoice' => 'sendInvoice',
        'complete',
    );
}
