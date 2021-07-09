<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708143656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creacion de la tabla de usuarios ...';
    }

    public function up(Schema $schema): void
    {
        $Table = $schema->createTable("usuarios");
        $Table->addColumn("id", "integer", array("unsigned" => true));
        $Table->addColumn("name", "string", array("length" => 255));
        $Table->addColumn("email", "string", array("length" => 255));
        $Table->addColumn("password", "string", array("length" => 255));
        $Table->addColumn("updated_at", "datetime");
        $Table->addColumn("created_at", "datetime");
        $Table->setPrimaryKey(array("id"));
        $Table->addUniqueIndex(array("email"));
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE usuarios');
    }
}
