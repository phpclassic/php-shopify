<?php

namespace PHPShopify\Http;

class CurlResponse {
    /** @var int */
    private $status;
    /** @var array */
    private $headers = [];
    private $body;

    public function __construct(int $status, array $headers, $body) {
        $this->status = $status;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function getHeader(string $key): ?string {
        return $this->headers[$key][0] ?? null;
    }

    public function getBody() {
        return $this->body;
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function __toString() {
        $body = $this->getBody();
        $body = $body ? : '';

        return $body;
    }
}
