<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210715215336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Añadimos campo a tabla';
    }

    public function up(Schema $schema): void
    {
        $Table =  $schema->getTable('users');
        $Table->addColumn("email_verified_at", "datetime", array("notnull" => false));
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP COLUMN email_verified_at;');
    }
}
