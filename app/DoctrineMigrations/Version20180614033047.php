<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180614033047 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tipo_dispositivo CHANGE nombre nombre VARCHAR(30) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957B08163A909126 ON tipo_dispositivo (nombre)');
        $this->addSql('ALTER TABLE tipo_software CHANGE nombre nombre VARCHAR(30) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A11532063A909126 ON tipo_software (nombre)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_957B08163A909126 ON tipo_dispositivo');
        $this->addSql('ALTER TABLE tipo_dispositivo CHANGE nombre nombre VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX UNIQ_A11532063A909126 ON tipo_software');
        $this->addSql('ALTER TABLE tipo_software CHANGE nombre nombre VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
