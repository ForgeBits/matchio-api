<?php

namespace App\Controller\Team;

use App\Controller\Validators\Team\CreateTeamValidator;
use App\Handler\Team\CreateTeamHandler;
use App\Utils\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class CreateTeamController extends AbstractController
{
    public function __construct(
        public readonly CreateTeamHandler $handler,
        public readonly CreateTeamValidator $validator,
    ){}

    #[Route('/team', name: 'team_create', methods: ['POST'], format: 'json')]
    public function create(Request $request): JsonResponse
    {
        try {
            $handler = $this->handler->handle($request->toArray());

            return ApiResponse::class::success($handler);
        } catch (Throwable $th) {
            return ApiResponse::class::error($th->getMessage());
        }
    }
}