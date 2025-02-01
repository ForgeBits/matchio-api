<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250131201633 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->getTable('team');

        $table->addColumn('country', 'string')
            ->setLength(100)
            ->setComment('Name of the country where the team is located.')
            ->setNotnull(true);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('team');

        $table->dropColumn('country');
    }
}
