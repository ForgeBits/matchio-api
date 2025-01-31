<?php

namespace App\Handler\Team;

use App\Dto\TeamDto;
use App\Handler\HandlerInterface;
use App\Repository\TeamRepository;
use App\Utils\Filter;
use App\Utils\PaginatorDetails;
use DateMalformedStringException;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class PaginateTeamHandler implements HandlerInterface
{
    public function __construct(
        public readonly EntityManagerInterface $em,
        public readonly TeamRepository $repository,
        public readonly Filter $filter,
        public readonly PaginatorInterface $paginator,
    ){}

    /**
     * @throws DateMalformedStringException
     * @throws \Exception
     */
    public function handle(...$args): array
    {
        $query = $this->repository->createQueryBuilder('t');

        if ($this->filter->filterExists('name')) {
            $query->where('t.name LIKE :name')
                ->setParameter('name', '%' . $this->filter->getFilter('name') . '%');
        }

        if ($this->filter->filterExists('city')) {
            $query->andWhere('t.city LIKE :city')
                ->setParameter('city', '%' . $this->filter->getFilter('city') . '%');
        }

        if ($this->filter->getOrderBy()) {
            $query->orderBy('t.'.$this->filter->getOrderBy(), $this->filter->getOrderDirection() ?? 'ASC');
        }

        $query->getQuery();

        $paginator = $this->paginator->paginate($query, $this->filter->getPage(), $this->filter->getLimit());
        $dto = TeamDto::toDTOCollection($paginator->getItems());

        $paginateDetails = new PaginatorDetails(
            $dto,
            $this->filter->getLimit(),
            $paginator->getCurrentPageNumber(),
            $paginator->getTotalItemCount(),
        );

        return $paginateDetails->toArray();
    }
}