<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190624133315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE github_owner (id INT AUTO_INCREMENT NOT NULL, github_id INT NOT NULL, url VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, bio VARCHAR(255) DEFAULT NULL, public_repos INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE github_repository ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE github_repository ADD CONSTRAINT FK_7A865C287E3C61F9 FOREIGN KEY (owner_id) REFERENCES github_owner (id)');
        $this->addSql('CREATE INDEX IDX_7A865C287E3C61F9 ON github_repository (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE github_repository DROP FOREIGN KEY FK_7A865C287E3C61F9');
        $this->addSql('DROP TABLE github_owner');
        $this->addSql('DROP INDEX IDX_7A865C287E3C61F9 ON github_repository');
        $this->addSql('ALTER TABLE github_repository DROP owner_id');
    }
}
