<?php

namespace App\Controller\Team;

use App\Handler\Team\FindAllTeamHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetAllTeamController extends AbstractController
{
    public function __construct(
        public readonly FindAllTeamHandler $handler
    ){}

    #[Route('/team', name: 'team_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        try {
            $handler = $this->handler->handle();

            return $this->json([
                'message' => 'Teams retrieved successfully',
                'data' => $handler,
            ]);
        } catch (\Throwable $th) {
            return $this->json([
                'message' => $th->getMessage(),
            ], 400);
        }
    }
}