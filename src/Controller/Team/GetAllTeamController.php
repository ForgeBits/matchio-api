<?php

namespace App\Controller\Team;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetAllTeamController extends AbstractController
{
    #[Route('/team', name: 'team_list', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager): JsonResponse
    {
        $query = $entityManager->getRepository(Team::class)->findAll();

        return $this->json([
            'message' => 'Teams retrieved successfully',
            'data' => array_map(fn(Team $team) => $team->toArray(), $query),
        ]);
    }
}