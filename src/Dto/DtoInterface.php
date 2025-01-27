<?php

namespace App\Dto;

use App\Entity\EntityInterface;

interface DtoInterface
{
    public static function toDto(EntityInterface $entity): array;
    public static function toDTOCollection(array $items): array;
}