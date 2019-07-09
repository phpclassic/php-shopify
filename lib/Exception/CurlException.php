<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/19/16 10:26 AM UTC+06:00
 */

namespace PHPShopify\Exception;

use Throwable;

class CurlException extends \Exception
{
    private $lastCallData;

    public function __construct(
        $message = "",
        array $lastCallData = [
            'request_url' => null,
            'request_headers' => null,
            'request_data' => null,
            'response_headers' => null,
            'response_body' => null
        ],
        $code = 0,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->lastCallData = $lastCallData;
    }

    public function getLastCallData()
    {
        return $this->lastCallData;
    }
}