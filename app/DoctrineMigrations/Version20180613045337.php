<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180613045337 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE empresa CHANGE nombre nombre VARCHAR(80) NOT NULL, CHANGE cif cif VARCHAR(80) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B8D75A503A909126 ON empresa (nombre)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B8D75A50A53EB8E8 ON empresa (cif)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_B8D75A503A909126 ON empresa');
        $this->addSql('DROP INDEX UNIQ_B8D75A50A53EB8E8 ON empresa');
        $this->addSql('ALTER TABLE empresa CHANGE nombre nombre VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE cif cif VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
