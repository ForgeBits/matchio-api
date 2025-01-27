<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

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
class Team extends Entity implements EntityInterface
{
    #[ORM\Column(type: 'string', length: 255)]
    protected string $name;

    #[ORM\Column(type: 'datetime_immutable')]
    protected DateTimeImmutable $founded;

    #[ORM\Column(type: 'string', length: 255)]
    protected string $city;

    #[ORM\Column(type: 'string', length: 255)]
    protected string $stadium;

    #[ORM\Column(type: 'string', length: 255)]
    protected string $badge;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'founded' => $this->founded,
            'city' => $this->city,
            'stadium' => $this->stadium,
            'badge' => $this->badge,
        ];
    }
}