<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240913070936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__game AS SELECT id, username, created_at, score, number_of_tracks, uuid FROM game');
        $this->addSql('DROP TABLE game');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , score INTEGER DEFAULT NULL, number_of_tracks INTEGER NOT NULL, uuid CHAR(36) NOT NULL --(DC2Type:guid)
        )');
        $this->addSql('INSERT INTO game (id, username, created_at, score, number_of_tracks, uuid) SELECT id, username, created_at, score, number_of_tracks, uuid FROM __temp__game');
        $this->addSql('DROP TABLE __temp__game');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__game AS SELECT id, username, created_at, score, number_of_tracks, uuid FROM game');
        $this->addSql('DROP TABLE game');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , score INTEGER DEFAULT NULL, number_of_tracks INTEGER NOT NULL, uuid CHAR(36) NOT NULL)');
        $this->addSql('INSERT INTO game (id, username, created_at, score, number_of_tracks, uuid) SELECT id, username, created_at, score, number_of_tracks, uuid FROM __temp__game');
        $this->addSql('DROP TABLE __temp__game');
    }
}
