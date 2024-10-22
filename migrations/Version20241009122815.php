<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009122815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__release AS SELECT id, artist_id, released_at, title, thumbnail_url, type FROM "release"');
        $this->addSql('DROP TABLE "release"');
        $this->addSql('CREATE TABLE "release" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, artist_id INTEGER NOT NULL, released_at DATE NOT NULL --(DC2Type:date_immutable)
        , title VARCHAR(255) NOT NULL, thumbnail_url VARCHAR(255) NOT NULL, type INTEGER NOT NULL, CONSTRAINT FK_9E47031DB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "release" (id, artist_id, released_at, title, thumbnail_url, type) SELECT id, artist_id, released_at, title, thumbnail_url, type FROM __temp__release');
        $this->addSql('DROP TABLE __temp__release');
        $this->addSql('CREATE INDEX IDX_9E47031DB7970CF8 ON "release" (artist_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TEMPORARY TABLE __temp__release AS SELECT id, artist_id, title, thumbnail_url, type, released_at FROM "release"');
        $this->addSql('DROP TABLE "release"');
        $this->addSql('CREATE TABLE "release" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, artist_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, thumbnail_url VARCHAR(255) NOT NULL, type INTEGER NOT NULL, released_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_9E47031DB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "release" (id, artist_id, title, thumbnail_url, type, released_at) SELECT id, artist_id, title, thumbnail_url, type, released_at FROM __temp__release');
        $this->addSql('DROP TABLE __temp__release');
        $this->addSql('CREATE INDEX IDX_9E47031DB7970CF8 ON "release" (artist_id)');
    }
}
