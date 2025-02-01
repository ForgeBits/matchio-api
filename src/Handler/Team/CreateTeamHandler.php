<?php

namespace App\Handler\Team;

use App\Entity\Team;
use App\Handler\HandlerInterface;
use App\Repository\TeamRepository;
use DateMalformedStringException;
use DateTimeImmutable;

class CreateTeamHandler implements HandlerInterface
{
    public function __construct(
        public readonly TeamRepository $repository
    ){}

    /**
     * @throws DateMalformedStringException
     */
    public function handle(...$args): array
    {
        $data = $args[0];

        $team = new Team();
        $team->setName($data['name'])
            ->setFounded(new DateTimeImmutable($data['founded']))
            ->setStadium($data['stadium'])
            ->setCity($data['city'])
            ->setBadge($data['badge'])
            ->setCountry($data['country']);

        $this->repository->create($team);

        return $team->toDto();
    }
}