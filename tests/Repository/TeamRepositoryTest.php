<?php

namespace App\Tests\Repository;

use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Tests\Repository\Fixtures\TeamDataLoader;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManager;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class TeamRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    public static function teamProvider(): array
    {
        $sportRecife = (new Team())
            ->setName('Sport Club do Recife')
            ->setFounded(new DateTimeImmutable('1905-05-13'))
            ->setStadium('Ilha do Retiro')
            ->setCity('Recife')
            ->setBadge('https://upload.wikimedia.org/wikipedia/pt/8/8d/Sport_Club_do_Recife.png');

        $fortalezaEC = (new Team())
            ->setName('Fortaleza Esporte Clube')
            ->setFounded(new DateTimeImmutable('1918-10-18'))
            ->setStadium('Arena Castelão')
            ->setCity('Fortaleza')
            ->setBadge('https://upload.wikimedia.org/wikipedia/pt/0/0f/Fortaleza_Esporte_Clube.png');

        return [
            [$sportRecife],
            [$fortalezaEC],
        ];
    }

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $schemaTool->dropDatabase();
            $schemaTool->createSchema($metadata);
        }

        $purger = new ORMPurger($this->entityManager);
        $purger->purge();

        $loader = new Loader();
        $loader->addFixture(new TeamDataLoader());

        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    /**
     * @dataProvider teamProvider
     */
    public function testCreateTeam(Team $team)
    {
        $repositoty = $this->entityManager->getRepository(Team::class);

        /** @var TeamRepository $teamRepository */
        $repositoty->create($team);

        /** @var Team $foundTeam */
        $foundTeam = $repositoty->findOneBy(['name' => $team->getName()]);

        $this->assertNotNull($foundTeam->getId());
        $this->assertEquals($team->getName(), $foundTeam->getName());
        $this->assertEquals($team->getFounded(), $foundTeam->getFounded());
        $this->assertEquals($team->getStadium(), $foundTeam->getStadium());
        $this->assertEquals($team->getCity(), $foundTeam->getCity());
        $this->assertEquals($team->getBadge(), $foundTeam->getBadge());
    }

    public function testFindAll(): void
    {
        $teams = $this->entityManager
            ->getRepository(Team::class)
            ->findAll();

        $this->assertIsArray($teams);
        $this->assertCount(6, $teams);
    }
}