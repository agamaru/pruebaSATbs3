<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180520181145 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CFDE734E51');
        $this->addSql('DROP INDEX IDX_77D068CFDE734E51 ON software');
        $this->addSql('ALTER TABLE software ADD empresa_id INT DEFAULT NULL, DROP cliente_id');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CF521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('CREATE INDEX IDX_77D068CF521E1991 ON software (empresa_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CF521E1991');
        $this->addSql('DROP INDEX IDX_77D068CF521E1991 ON software');
        $this->addSql('ALTER TABLE software ADD cliente_id INT NOT NULL, DROP empresa_id');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CFDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('CREATE INDEX IDX_77D068CFDE734E51 ON software (cliente_id)');
    }
}
