<?php

namespace App\Exception;

use Throwable;

class RequestValidationException extends \Exception implements HasOwnResponseInterface
{
    private array $requestFails;

    public function __construct(array $requestFails = [], string $message = "Validation fail", int $code = 0, ?Throwable $previous = null)
    {
        $this->requestFails = $requestFails;
        parent::__construct($message, $code, $previous);
    }

    private function getRequestFails(): array
    {
        return $this->requestFails;
    }

    public function getResponse(): array
    {
        return [
            'success' => false,
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'errors' => $this->getRequestFails(),
        ];
    }
}