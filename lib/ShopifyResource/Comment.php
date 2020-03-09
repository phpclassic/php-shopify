<?php
/**
 * @see https://help.shopify.com/api/reference/comment Shopify API Reference for Comment
 */

namespace PHPShopify\ShopifyResource;

use PHPShopify\ShopifyResource;

/**
 * @property-read Event $Event
 * @method Event Event(integer $id = null)
 * @method array markSpam() Mark a Comment as spam
 * @method array markNotSpam() Mark a Comment as not spam
 * @method array approve() Approve a Comment
 * @method array remove() Remove a Comment
 * @method array restore() Restore a Comment
 */
class Comment extends ShopifyResource {
    protected $resourceKey = 'comment';
    protected $childResource = [
        'Event'
    ];

    protected $customPostActions = [
        'spam'      =>  'markSpam',
        'not_spam'  =>  'markNotSpam',
                        'approve',
                        'remove',
                        'restore'
    ];
}
