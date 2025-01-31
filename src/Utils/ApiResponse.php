<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    /**
     * Cria uma resposta de sucesso padronizada.
     *
     * @param mixed $data Os dados da resposta.
     * @param int $status O código HTTP (padrão: 200).
     * @param array $headers Cabeçalhos adicionais para a resposta.
     * @return JsonResponse
     */
    public static function success(mixed $data = null, int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data' => $data,
        ], $status, $headers);
    }

    /**
     * Cria uma resposta de erro padronizada.
     *
     * @param string $message A mensagem de erro.
     * @param int $status O código HTTP (padrão: 400).
     * @param array $errors Detalhes adicionais do erro (padrão: vazio).
     * @param array $headers Cabeçalhos adicionais para a resposta.
     * @return JsonResponse
     */
    public static function error(string $message, int $status = Response::HTTP_BAD_REQUEST, array $errors = [], array $headers = []): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status, $headers);
    }

    public static function notFound(string $message = 'Not found', array $errors = [], array $headers = []): JsonResponse
    {
        return self::error($message, Response::HTTP_NOT_FOUND, $errors, $headers);
    }

    public static function unauthorized(string $message = 'Unauthorized', array $errors = [], array $headers = []): JsonResponse
    {
        return self::error($message, Response::HTTP_UNAUTHORIZED, $errors, $headers);
    }

    public static function forbidden(string $message = 'Forbidden', array $errors = [], array $headers = []): JsonResponse
    {
        return self::error($message, Response::HTTP_FORBIDDEN, $errors, $headers);
    }

    public static function defaultError(string $message = 'An error occurred', array $errors = [], array $headers = []): JsonResponse
    {
        return self::error($message, Response::HTTP_INTERNAL_SERVER_ERROR, $errors, $headers);
    }
}