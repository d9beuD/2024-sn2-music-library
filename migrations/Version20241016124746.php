<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241016124746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__artist AS SELECT id, name, thumbnail_url FROM artist');
        $this->addSql('DROP TABLE artist');
        $this->addSql('CREATE TABLE artist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT 2 NOT NULL, name VARCHAR(255) NOT NULL, thumbnail_url VARCHAR(255) NOT NULL, CONSTRAINT FK_15996877E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO artist (id, name, thumbnail_url) SELECT id, name, thumbnail_url FROM __temp__artist');
        $this->addSql('DROP TABLE __temp__artist');
        $this->addSql('CREATE INDEX IDX_15996877E3C61F9 ON artist (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__artist AS SELECT id, name, thumbnail_url FROM artist');
        $this->addSql('DROP TABLE artist');
        $this->addSql('CREATE TABLE artist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, thumbnail_url VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO artist (id, name, thumbnail_url) SELECT id, name, thumbnail_url FROM __temp__artist');
        $this->addSql('DROP TABLE __temp__artist');
    }
}
