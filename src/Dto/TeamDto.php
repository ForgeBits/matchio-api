<?php

namespace App\Dto;

use App\Entity\EntityInterface;

class TeamDto implements DtoInterface
{
    public static function toDto(EntityInterface $entity): array
    {
        return [
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'founded' => $entity->getFounded()->format('Y-m-d'),
            'city' => $entity->getCity(),
            'stadium' => $entity->getStadium(),
            'badge' => $entity->getBadge(),
        ];
    }

    /**
     * @param array<EntityInterface> $items
     * @return array
     */
    public static function toDTOCollection(array $items): array
    {
        return array_map(function ($item) {
            return self::toDto($item);
        }, $items);
    }
}