<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180528162757 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tipo_software (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CFA9276E6C');
        $this->addSql('ALTER TABLE software CHANGE tipo_id tipo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CFA9276E6C FOREIGN KEY (tipo_id) REFERENCES tipo_software (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CFA9276E6C');
        $this->addSql('DROP TABLE tipo_software');
        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CFA9276E6C');
        $this->addSql('ALTER TABLE software CHANGE tipo_id tipo_id INT NOT NULL');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CFA9276E6C FOREIGN KEY (tipo_id) REFERENCES tipo (id)');
    }
}
