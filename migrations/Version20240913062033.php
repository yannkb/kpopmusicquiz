<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240913062033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__game AS SELECT id, username, created_at, score, game_size FROM game');
        $this->addSql('DROP TABLE game');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , score INTEGER NOT NULL, number_of_tracks INTEGER NOT NULL)');
        $this->addSql('INSERT INTO game (id, username, created_at, score, number_of_tracks) SELECT id, username, created_at, score, game_size FROM __temp__game');
        $this->addSql('DROP TABLE __temp__game');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__game AS SELECT id, username, created_at, score, number_of_tracks FROM game');
        $this->addSql('DROP TABLE game');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , score INTEGER NOT NULL, game_size INTEGER NOT NULL)');
        $this->addSql('INSERT INTO game (id, username, created_at, score, game_size) SELECT id, username, created_at, score, number_of_tracks FROM __temp__game');
        $this->addSql('DROP TABLE __temp__game');
    }
}
