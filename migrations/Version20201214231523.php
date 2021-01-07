<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214231523 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mount ADD sources_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mount ADD CONSTRAINT FK_3AE9FA03DD51D0F7 FOREIGN KEY (sources_id) REFERENCES source (id)');
        $this->addSql('CREATE INDEX IDX_3AE9FA03DD51D0F7 ON mount (sources_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mount DROP FOREIGN KEY FK_3AE9FA03DD51D0F7');
        $this->addSql('DROP INDEX IDX_3AE9FA03DD51D0F7 ON mount');
        $this->addSql('ALTER TABLE mount DROP sources_id');
    }
}
