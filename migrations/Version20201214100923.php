<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214100923 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD status VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE mount ADD currency_type_id INT DEFAULT NULL, ADD expansion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mount ADD CONSTRAINT FK_3AE9FA0318E5767C FOREIGN KEY (currency_type_id) REFERENCES currency_type (id)');
        $this->addSql('ALTER TABLE mount ADD CONSTRAINT FK_3AE9FA035C15249D FOREIGN KEY (expansion_id) REFERENCES expansion (id)');
        $this->addSql('CREATE INDEX IDX_3AE9FA0318E5767C ON mount (currency_type_id)');
        $this->addSql('CREATE INDEX IDX_3AE9FA035C15249D ON mount (expansion_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP status');
        $this->addSql('ALTER TABLE mount DROP FOREIGN KEY FK_3AE9FA0318E5767C');
        $this->addSql('ALTER TABLE mount DROP FOREIGN KEY FK_3AE9FA035C15249D');
        $this->addSql('DROP INDEX IDX_3AE9FA0318E5767C ON mount');
        $this->addSql('DROP INDEX IDX_3AE9FA035C15249D ON mount');
        $this->addSql('ALTER TABLE mount DROP currency_type_id, DROP expansion_id');
    }
}
