<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180529050546 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE usuario');
        $this->addSql('ALTER TABLE servidor ADD usuario VARCHAR(255) NOT NULL, ADD pass VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, servidor_id INT NOT NULL, nombre_usuario VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, admin TINYINT(1) NOT NULL, tecnico TINYINT(1) NOT NULL, INDEX IDX_2265B05D41FCE9BD (servidor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D41FCE9BD FOREIGN KEY (servidor_id) REFERENCES servidor (id)');
        $this->addSql('ALTER TABLE servidor DROP usuario, DROP pass');
    }
}
