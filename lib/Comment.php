<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 10:58 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/comment Shopify API Reference for Comment
 */

namespace PHPShopify;


/*
 * --------------------------------------------------------------------------
 * Comment -> Custom actions
 * --------------------------------------------------------------------------
 * @method array spam()         Mark a Comment as spam
 * @method array notSpam()      Mark a Comment as not spam
 * @method array approve()      Approve a Comment
 * @method array remove()       Remove a Comment
 * @method array restore()      Restore a Comment
 *
 */
class Comment extends ShopifyAPI
{
    /**
     * Key of the API Resource which is used to fetch data from request responses
     *
     * @var string
     */
    protected $resourceKey = 'comment';

    /**
     * List of custom POST actions
     * @example: ['enable', 'disable', 'remove','default' => 'makeDefault']
     * Methods can be called like enable(), disable(), remove(), makeDefault() etc.
     * If any array item has an associative key => value pair, value will be considered as the method name and key will be the associated path to be used with the action.
     *
     * @var array
     */
    protected $customPostActions = array(
        'spam',
        'not_spam' => 'notSpam',
        'approve',
        'remove',
        'restore',
    );
}