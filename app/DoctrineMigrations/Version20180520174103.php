<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180520174103 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE punto_acceso (id INT AUTO_INCREMENT NOT NULL, router_id INT DEFAULT NULL, ip VARCHAR(255) NOT NULL, usuario VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, wep VARCHAR(255) NOT NULL, INDEX IDX_CD77E2C1169071B9 (router_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE punto_acceso ADD CONSTRAINT FK_CD77E2C1169071B9 FOREIGN KEY (router_id) REFERENCES router (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE punto_acceso');
    }
}
