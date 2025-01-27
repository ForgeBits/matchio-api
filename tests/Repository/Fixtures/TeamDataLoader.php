<?php

namespace App\Tests\Repository\Fixtures;

use App\Entity\Team;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeamDataLoader implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $liverpool = (new Team())->setName('Liverpool')
            ->setFounded(new DateTimeImmutable('1892-06-03'))
            ->setCity('Liverpool')
            ->setStadium('Anfield')
            ->setBadge('https://upload.wikimedia.org/wikipedia/en/0/0c/Liverpool_FC.svg');

        $manchesterUnited = (new Team())->setName('Manchester United')
            ->setFounded(new DateTimeImmutable('1878-01-01'))
            ->setCity('Manchester')
            ->setStadium('Old Trafford')
            ->setBadge('https://upload.wikimedia.org/wikipedia/en/7/7a/Manchester_United_FC_crest.svg');

        $chelsea = (new Team())->setName('Chelsea')
            ->setFounded(new DateTimeImmutable('1905-03-10'))
            ->setCity('London')
            ->setStadium('Stamford Bridge')
            ->setBadge('https://upload.wikimedia.org/wikipedia/en/c/cc/Chelsea_FC.svg');

        $arsenal = (new Team())->setName('Arsenal')
            ->setFounded(new DateTimeImmutable('1886-12-01'))
            ->setCity('London')
            ->setStadium('Emirates Stadium')
            ->setBadge('https://upload.wikimedia.org/wikipedia/en/5/53/Arsenal_FC.svg');

        $manchesterCity = (new Team())->setName('Manchester City')
            ->setFounded(new DateTimeImmutable('1880-01-01'))
            ->setCity('Manchester')
            ->setStadium('Etihad Stadium')
            ->setBadge('https://upload.wikimedia.org/wikipedia/en/e/eb/Manchester_City_FC_badge.svg');

        $tottenham = (new Team())->setName('Tottenham Hotspur')
            ->setFounded(new DateTimeImmutable('1882-09-05'))
            ->setCity('London')
            ->setStadium('Tottenham Hotspur Stadium')
            ->setBadge('https://upload.wikimedia.org/wikipedia/en/b/b4/Tottenham_Hotspur.svg');

        $manager->persist($liverpool);
        $manager->persist($manchesterUnited);
        $manager->persist($chelsea);
        $manager->persist($arsenal);
        $manager->persist($manchesterCity);
        $manager->persist($tottenham);
        $manager->flush();
    }
}