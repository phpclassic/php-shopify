<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 10:58 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/comment Shopify API Reference for Comment
 */

namespace PHPShopify;


/**
 *
 * --------------------------------------------------------------------------
 * Comment -> Child Resources
 * --------------------------------------------------------------------------
 * @property-read Event $Event
 *
 * @method Event Event(integer $id = null)
 *
 * --------------------------------------------------------------------------
 * Comment -> Custom actions
 * --------------------------------------------------------------------------
 * @method array markSpam()     Mark a Comment as spam
 * @method array markNotSpam()  Mark a Comment as not spam
 * @method array approve()      Approve a Comment
 * @method array remove()       Remove a Comment
 * @method array restore()      Restore a Comment
 *
 */
class Comment extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    protected $resourceKey = 'comment';

    /**
     * @inheritDoc
     */
    protected $childResource = array (
        'Event',
    );

    /**
     * @inheritDoc
     */
    protected $customPostActions = array(
        'spam'      =>  'markSpam',
        'not_spam'  =>  'markNotSpam',
                        'approve',
                        'remove',
                        'restore',
    );
}