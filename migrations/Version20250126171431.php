<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Psr\Log\LoggerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250126171431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('team')
            ->setComment('Table created to store the teams of the system.');

        $table->addColumn('id', 'string')
            ->setLength(36)
            ->setComment('Primary key of the team.');

        $table->addColumn('name', 'string')
            ->setLength(100)
            ->setComment('Name of the team.');

        $table->addColumn('founded', 'date_immutable')
            ->setComment('Date of foundation of the team.');

        $table->addColumn('stadium', 'string')
            ->setLength(255)
            ->setComment('Name of the team stadium.');

        $table->addColumn('city', 'string')
            ->setLength(100)
            ->setComment('Name of the city where the team is located.');

        $table->addColumn('badge', 'string')
            ->setLength(255)
            ->setComment('URL of the team badge.');

        $table->addColumn('created_at', 'datetime_immutable')
            ->setComment('Date of creation of the record.');

        $table->addColumn('updated_at', 'datetime_immutable')
            ->setComment('Date of update of the record.')
            ->setNotnull(false);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('team');
    }
}
