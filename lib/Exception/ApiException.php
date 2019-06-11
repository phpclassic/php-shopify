<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 10:28 AM UTC+06:00
 */

namespace PHPShopify\Exception;

use Throwable;

class ApiException extends \Exception
{
    private $lastRequestData;

    public function __construct($message = "", array $lastRequestData = ['request_url' => null, 'request_data' => null], $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->lastRequestData = $lastRequestData;
    }

    public function getLastRequestData()
    {
        return $this->lastRequestData;
    }
}