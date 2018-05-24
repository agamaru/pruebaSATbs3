<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180524180648 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, nombre_cliente VARCHAR(255) NOT NULL, direccion VARCHAR(255) NOT NULL, telefono VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE confi_red (id INT AUTO_INCREMENT NOT NULL, empresa_id INT NOT NULL, dominio VARCHAR(255) NOT NULL, mascara_red VARCHAR(255) NOT NULL, ip_fija_ext VARCHAR(255) NOT NULL, dns1 VARCHAR(255) NOT NULL, dns2 VARCHAR(255) DEFAULT NULL, INDEX IDX_8D644C72521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE software (id INT AUTO_INCREMENT NOT NULL, tipo_id INT NOT NULL, empresa_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, usuario VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, fecha_renovacion DATE NOT NULL, notas LONGTEXT DEFAULT NULL, INDEX IDX_77D068CFA9276E6C (tipo_id), INDEX IDX_77D068CF521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE empresa (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, cif VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE punto_acceso (id INT AUTO_INCREMENT NOT NULL, router_id INT NOT NULL, ip VARCHAR(255) NOT NULL, usuario VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, wep VARCHAR(255) NOT NULL, INDEX IDX_CD77E2C1169071B9 (router_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE router (id INT AUTO_INCREMENT NOT NULL, empresa_id INT NOT NULL, ip VARCHAR(255) NOT NULL, usuario VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, wep VARCHAR(255) NOT NULL, INDEX IDX_45D2F225521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, servidor_id INT NOT NULL, nombre_usuario VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, admin TINYINT(1) NOT NULL, tecnico TINYINT(1) NOT NULL, INDEX IDX_2265B05D41FCE9BD (servidor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servidor (id INT AUTO_INCREMENT NOT NULL, empresa_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, ip VARCHAR(255) NOT NULL, detalles LONGTEXT NOT NULL, INDEX IDX_FB952FF0521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE confi_red ADD CONSTRAINT FK_8D644C72521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CFA9276E6C FOREIGN KEY (tipo_id) REFERENCES tipo (id)');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CF521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE punto_acceso ADD CONSTRAINT FK_CD77E2C1169071B9 FOREIGN KEY (router_id) REFERENCES router (id)');
        $this->addSql('ALTER TABLE router ADD CONSTRAINT FK_45D2F225521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D41FCE9BD FOREIGN KEY (servidor_id) REFERENCES servidor (id)');
        $this->addSql('ALTER TABLE servidor ADD CONSTRAINT FK_FB952FF0521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CFA9276E6C');
        $this->addSql('ALTER TABLE confi_red DROP FOREIGN KEY FK_8D644C72521E1991');
        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CF521E1991');
        $this->addSql('ALTER TABLE router DROP FOREIGN KEY FK_45D2F225521E1991');
        $this->addSql('ALTER TABLE servidor DROP FOREIGN KEY FK_FB952FF0521E1991');
        $this->addSql('ALTER TABLE punto_acceso DROP FOREIGN KEY FK_CD77E2C1169071B9');
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D41FCE9BD');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE confi_red');
        $this->addSql('DROP TABLE software');
        $this->addSql('DROP TABLE tipo');
        $this->addSql('DROP TABLE empresa');
        $this->addSql('DROP TABLE punto_acceso');
        $this->addSql('DROP TABLE router');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE servidor');
    }
}
