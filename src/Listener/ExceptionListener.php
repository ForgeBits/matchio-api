<?php

namespace App\Listener;

use App\Exception\HasOwnResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $this->logger->error(sprintf('Exception: %s with message: %s', get_class($exception), $exception->getMessage()));

        $statusCode = $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof HasOwnResponseInterface){
            $response = new JsonResponse($exception->getResponse(), $statusCode);
        } else {
            $response = $this->defaultResponse($exception);
        }

        $event->setResponse($response);
    }

    private function defaultResponse(\Throwable $throwable): JsonResponse
    {
        return new JsonResponse([
            'timestamp' => date('Y-m-d H:i:s'),
            'success' => false,
            'message' => 'An error occurred',
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'details' => $throwable->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}