<?php

namespace App\Entity;

use App\Dto\DtoInterface;
use BadMethodCallException;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

abstract class Entity
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    protected string $id;

    #[ORM\Column(type: 'datetime_immutable')]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    protected DateTimeImmutable $updatedAt;


    public function __call(string $name, array $arguments)
    {
        if (str_starts_with($name, 'get')) {
            $property = lcfirst(substr($name, 3));

            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }

        if (str_starts_with($name, 'set')) {
            $property = lcfirst(substr($name, 3));

            if (property_exists($this, $property)) {
                $this->$property = $arguments[0];
                return $this;
            }
        }

        throw new BadMethodCallException(sprintf('Method "%s" does not exist on class %s.', $name, __CLASS__));
    }

    public function toDto(): array
    {
        /** @var DtoInterface $class */
        $class = $this->getClassDto();

        return $class::toDto($this);
    }

    public function toDTOCollection(array $items): array
    {
        /** @var DtoInterface $class */
        $class = $this->getClassDto();

        return $class::toDTOCollection($items);
    }

    private function getClassDto(): string
    {
        $namespace = "App\\Dto\\";
        $className = explode('\\', static::class);

        return $namespace . end($className) . 'Dto';
    }

    public abstract function toArray(): array;

    #[ORM\PrePersist]
    public function setTimestampsOnCreate(): void
    {
        $this->id = Uuid::uuid4()->toString();

        $now = new DateTimeImmutable('now');
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }
}