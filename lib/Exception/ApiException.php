<?php

namespace PHPShopify\Exception;

class ApiException extends SdkException {
    public static function factory(string $message, int $status): void {
        if ($message === 'Unavailable Shop') {
            throw new ShopUnavailableException($message, $status);
        }

        if (preg_match('/Exceeded (\d+) calls per second for api client\. Reduce request rates to resume uninterrupted service\./', $message)) {
            throw new ResourceRateLimitException($message, $status);
        }

        throw new self($message, $status);
    }
}
