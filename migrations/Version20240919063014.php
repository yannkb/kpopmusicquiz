<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240919063014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__song AS SELECT id, spotify_id, title, artist, preview_url, image_url FROM song');
        $this->addSql('DROP TABLE song');
        $this->addSql('CREATE TABLE song (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, spotify_id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, artist VARCHAR(255) NOT NULL, preview_url VARCHAR(255) NOT NULL, image_url VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO song (id, spotify_id, title, artist, preview_url, image_url) SELECT id, spotify_id, title, artist, preview_url, image_url FROM __temp__song');
        $this->addSql('DROP TABLE __temp__song');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_33EDEEA1A905FC5C ON song (spotify_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__song AS SELECT id, spotify_id, title, artist, preview_url, image_url FROM song');
        $this->addSql('DROP TABLE song');
        $this->addSql('CREATE TABLE song (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, spotify_id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, artist VARCHAR(255) NOT NULL, preview_url VARCHAR(255) NOT NULL, image_url VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO song (id, spotify_id, title, artist, preview_url, image_url) SELECT id, spotify_id, title, artist, preview_url, image_url FROM __temp__song');
        $this->addSql('DROP TABLE __temp__song');
    }
}
