<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180528172610 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dispositivo_red (id INT AUTO_INCREMENT NOT NULL, tipo_id INT DEFAULT NULL, empresa_id INT DEFAULT NULL, ip VARCHAR(255) NOT NULL, usuario VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, wep VARCHAR(255) NOT NULL, INDEX IDX_569FA85FA9276E6C (tipo_id), INDEX IDX_569FA85F521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dispositivo_red ADD CONSTRAINT FK_569FA85FA9276E6C FOREIGN KEY (tipo_id) REFERENCES tipo_dispositivo (id)');
        $this->addSql('ALTER TABLE dispositivo_red ADD CONSTRAINT FK_569FA85F521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE dispositivo_red');
    }
}
