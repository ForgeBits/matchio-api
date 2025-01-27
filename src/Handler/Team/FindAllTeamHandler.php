<?php

namespace App\Handler\Team;

use App\Dto\TeamDto;
use App\Handler\HandlerInterface;
use App\Repository\TeamRepository;
use DateMalformedStringException;

class FindAllTeamHandler implements HandlerInterface
{
    public function __construct(
        public readonly TeamRepository $repository
    ){}

    /**
     * @throws DateMalformedStringException
     */
    public function handle(...$args): array
    {
        $teams = $this->repository->findAll();

        return TeamDto::toDTOCollection($teams);
    }
}