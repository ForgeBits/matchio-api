<?php

namespace App\Controller\Team;

use App\Handler\Team\CreateTeamHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CreateTeamController extends AbstractController
{
    public function __construct(
        public readonly CreateTeamHandler $handler
    ){}

    #[Route('/team', name: 'team_create', methods: ['POST'], format: 'json')]
    public function create(Request $request): JsonResponse
    {
        try {
            $handler = $this->handler->handle($request->toArray());

            return $this->json([
                'message' => 'Team created successfully',
                'data' => $handler,
            ]);
        } catch (\Throwable $th) {
            return $this->json([
                'message' => $th->getMessage(),
            ], 400);
        }
    }
}