<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180519163617 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE confi_red ADD cliente_id INT NOT NULL, DROP cliente');
        $this->addSql('ALTER TABLE confi_red ADD CONSTRAINT FK_8D644C72DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('CREATE INDEX IDX_8D644C72DE734E51 ON confi_red (cliente_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE confi_red DROP FOREIGN KEY FK_8D644C72DE734E51');
        $this->addSql('DROP INDEX IDX_8D644C72DE734E51 ON confi_red');
        $this->addSql('ALTER TABLE confi_red ADD cliente VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP cliente_id');
    }
}
