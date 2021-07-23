<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210723120049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Añadimos campo a tabla';
    }

    public function up(Schema $schema): void
    {
        $Table =  $schema->getTable('usuarios');
        $Table->addColumn("remember_me", "string", array("length" => 255,"notnull" => false));
        $Table->addUniqueIndex(array("remember_me"));
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE usuraios DROP COLUMN remember_me;');
    }
}
