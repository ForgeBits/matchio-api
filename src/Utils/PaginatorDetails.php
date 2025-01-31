<?php

namespace App\Utils;

class PaginatorDetails
{
    public readonly int $totalPages;
    public readonly int|null $nextPage;
    public readonly int|null $previousPage;

    public function __construct(
        public readonly array $data,
        public readonly int $limit,
        public readonly int $page,
        public readonly int $totalItems,
    ){
        $this->totalPages = ceil($this->totalItems / $this->limit);
        $this->nextPage = ($page < $this->totalPages) ? $page + 1 : null;
        $this->previousPage = ($page > 1) ? $page - 1 : null;
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'details' => [
                'limit' => $this->limit,
                'page' => $this->page,
                'totalPages' => $this->totalPages,
                'totalItems' => $this->totalItems,
                'nextPage' => $this->nextPage,
                'previousPage' => $this->previousPage,
            ]
        ];
    }
}