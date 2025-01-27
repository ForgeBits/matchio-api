<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use BadMethodCallException;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Ramsey\Uuid\Uuid;

/**
 * @method string getId()
 * @method self setId(string $id)
 * @method string getName()
 * @method self setName(string $name)
 * @method DateTimeImmutable getFounded()
 * @method self setFounded(DateTimeImmutable $founded)
 * @method string getCity()
 * @method self setCity(string $city)
 * @method string getStadium()
 * @method self setStadium(string $stadium)
 * @method string getBadge()
 * @method self setBadge(string $badge)
 * @method DateTimeImmutable getCreatedAt()
 * @method self setCreatedAt(DateTime $createdAt)
 * @method DateTimeImmutable getUpdatedAt()
 * @method self setUpdatedAt(DateTime $updatedAt)
 * /
 */
#[ORM\Entity(repositoryClass: TeamRepository::class), HasLifecycleCallbacks]
class Team
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $founded;

    #[ORM\Column(type: 'string', length: 255)]
    private string $city;

    #[ORM\Column(type: 'string', length: 255)]
    private string $stadium;

    #[ORM\Column(type: 'string', length: 255)]
    private string $badge;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    public static function team(): self
    {
        return new self();
    }

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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'founded' => $this->founded,
            'stadium' => $this->stadium,
            'badge' => $this->badge,
        ];
    }

    #[ORM\PrePersist]
    public function setTimestampsOnCreate(): void
    {
        $this->id = Uuid::uuid4()->toString();

        $now = new DateTimeImmutable('now');
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }
}