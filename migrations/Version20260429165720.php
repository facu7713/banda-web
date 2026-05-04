<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260429165720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE banda (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE cancion (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, audio VARCHAR(255) NOT NULL, tipo VARCHAR(255) NOT NULL, banda_id INT DEFAULT NULL, INDEX IDX_E4620FA09EFB0C1D (banda_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE comentario (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, puntuacion INT NOT NULL, fecha_publicacion DATETIME NOT NULL, mensaje LONGTEXT NOT NULL, visible TINYINT DEFAULT 1 NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE evento (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, foto VARCHAR(255) NOT NULL, info LONGTEXT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE foto (id INT AUTO_INCREMENT NOT NULL, imagen VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, info LONGTEXT NOT NULL, categoria VARCHAR(255) NOT NULL, banda_id INT DEFAULT NULL, INDEX IDX_EADC3BE59EFB0C1D (banda_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE `show` (id INT AUTO_INCREMENT NOT NULL, fecha DATETIME NOT NULL, lugar VARCHAR(255) NOT NULL, ciudad VARCHAR(255) NOT NULL, banda_id INT DEFAULT NULL, evento_id INT DEFAULT NULL, INDEX IDX_320ED9019EFB0C1D (banda_id), INDEX IDX_320ED90187A5F842 (evento_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, info LONGTEXT NOT NULL, banda_id INT DEFAULT NULL, INDEX IDX_7CC7DA2C9EFB0C1D (banda_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cancion ADD CONSTRAINT FK_E4620FA09EFB0C1D FOREIGN KEY (banda_id) REFERENCES banda (id)');
        $this->addSql('ALTER TABLE foto ADD CONSTRAINT FK_EADC3BE59EFB0C1D FOREIGN KEY (banda_id) REFERENCES banda (id)');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED9019EFB0C1D FOREIGN KEY (banda_id) REFERENCES banda (id)');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED90187A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C9EFB0C1D FOREIGN KEY (banda_id) REFERENCES banda (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cancion DROP FOREIGN KEY FK_E4620FA09EFB0C1D');
        $this->addSql('ALTER TABLE foto DROP FOREIGN KEY FK_EADC3BE59EFB0C1D');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED9019EFB0C1D');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED90187A5F842');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C9EFB0C1D');
        $this->addSql('DROP TABLE banda');
        $this->addSql('DROP TABLE cancion');
        $this->addSql('DROP TABLE comentario');
        $this->addSql('DROP TABLE evento');
        $this->addSql('DROP TABLE foto');
        $this->addSql('DROP TABLE `show`');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
