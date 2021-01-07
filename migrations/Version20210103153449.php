<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210103153449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(50) NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(10) NOT NULL, userid INT NOT NULL, mountid INT NOT NULL, uname VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expansion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mount (id INT AUTO_INCREMENT NOT NULL, currency_type_id INT DEFAULT NULL, expansion_id INT DEFAULT NULL, source_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, faction VARCHAR(30) NOT NULL, type VARCHAR(50) NOT NULL, currency DOUBLE PRECISION NOT NULL, INDEX IDX_3AE9FA0318E5767C (currency_type_id), INDEX IDX_3AE9FA035C15249D (expansion_id), INDEX IDX_3AE9FA03953C1C61 (source_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(50) NOT NULL, code VARCHAR(9) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(40) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, uname VARCHAR(30) NOT NULL, image VARCHAR(60) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649887739B8 (uname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mount ADD CONSTRAINT FK_3AE9FA0318E5767C FOREIGN KEY (currency_type_id) REFERENCES currency_type (id)');
        $this->addSql('ALTER TABLE mount ADD CONSTRAINT FK_3AE9FA035C15249D FOREIGN KEY (expansion_id) REFERENCES expansion (id)');
        $this->addSql('ALTER TABLE mount ADD CONSTRAINT FK_3AE9FA03953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mount DROP FOREIGN KEY FK_3AE9FA0318E5767C');
        $this->addSql('ALTER TABLE mount DROP FOREIGN KEY FK_3AE9FA035C15249D');
        $this->addSql('ALTER TABLE mount DROP FOREIGN KEY FK_3AE9FA03953C1C61');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE currency_type');
        $this->addSql('DROP TABLE expansion');
        $this->addSql('DROP TABLE mount');
        $this->addSql('DROP TABLE reset');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP TABLE user');
    }
}
