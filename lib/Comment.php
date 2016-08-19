<?php
/**
 * Created by PhpStorm.
 * User: tareq
 * Date: 8/19/16
 * Time: 10:58 AM
 */

namespace PHPShopify;


class Comment extends ShopifyAPI
{
    protected $resourceKey = 'comment';
    protected $customPostActions = array(
        'spam',
        'not_spam' => 'notSpam',
        'approve',
        'remove',
        'restore',
    );
}