<?php

namespace App\Controller\Team;

use App\Controller\Validators\Team\PaginateTeamValidator;
use App\Handler\Team\PaginateTeamHandler;
use App\Utils\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class PaginateTeamController extends AbstractController
{
    public function __construct(
        public readonly PaginateTeamHandler $handler
    ){}

    #[Route('/team', name: 'team_list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        try {
            $handler = $this->handler->handle($request->query->all());

            return ApiResponse::success($handler, 'Teams retrieved successfully');
        } catch (\Throwable $th) {
            return ApiResponse::defaultError($th->getMessage());
        }
    }
}