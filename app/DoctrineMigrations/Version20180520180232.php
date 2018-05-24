<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180520180232 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE confi_red DROP FOREIGN KEY FK_8D644C72DE734E51');
        $this->addSql('DROP INDEX IDX_8D644C72DE734E51 ON confi_red');
        $this->addSql('ALTER TABLE confi_red ADD empresa_id INT DEFAULT NULL, DROP cliente_id');
        $this->addSql('ALTER TABLE confi_red ADD CONSTRAINT FK_8D644C72521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('CREATE INDEX IDX_8D644C72521E1991 ON confi_red (empresa_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE confi_red DROP FOREIGN KEY FK_8D644C72521E1991');
        $this->addSql('DROP INDEX IDX_8D644C72521E1991 ON confi_red');
        $this->addSql('ALTER TABLE confi_red ADD cliente_id INT NOT NULL, DROP empresa_id');
        $this->addSql('ALTER TABLE confi_red ADD CONSTRAINT FK_8D644C72DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('CREATE INDEX IDX_8D644C72DE734E51 ON confi_red (cliente_id)');
    }
}
