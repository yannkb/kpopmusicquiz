<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240913054301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , score INTEGER NOT NULL, game_size INTEGER NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__song AS SELECT id, spotify_id, title, artist, preview_url FROM song');
        $this->addSql('DROP TABLE song');
        $this->addSql('CREATE TABLE song (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, spotify_id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, artist VARCHAR(255) NOT NULL, preview_url VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO song (id, spotify_id, title, artist, preview_url) SELECT id, spotify_id, title, artist, preview_url FROM __temp__song');
        $this->addSql('DROP TABLE __temp__song');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game');
        $this->addSql('CREATE TEMPORARY TABLE __temp__song AS SELECT id, spotify_id, title, artist, preview_url FROM song');
        $this->addSql('DROP TABLE song');
        $this->addSql('CREATE TABLE song (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, spotify_id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, artist VARCHAR(255) NOT NULL, preview_url VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO song (id, spotify_id, title, artist, preview_url) SELECT id, spotify_id, title, artist, preview_url FROM __temp__song');
        $this->addSql('DROP TABLE __temp__song');
    }
}
