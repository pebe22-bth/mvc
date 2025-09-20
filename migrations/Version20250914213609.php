<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250914213609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE account (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
                player_id INTEGER NOT NULL, 
                amount INTEGER NOT NULL, 
                highscore INTEGER DEFAULT NULL,
                FOREIGN KEY(player_id) REFERENCES player(id)
                )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE player (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
                name VARCHAR(255) NOT NULL
                )
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE account
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE player
        SQL);
    }
}
