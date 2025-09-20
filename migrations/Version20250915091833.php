<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250915091833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__highscore AS SELECT id, player_id, coins FROM highscore
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE highscore
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE highscore (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, coins INTEGER NOT NULL, CONSTRAINT FK_901BB39212469DE2 FOREIGN KEY (category_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO highscore (id, category_id, coins) SELECT id, player_id, coins FROM __temp__highscore
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__highscore
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_901BB39212469DE2 ON highscore (category_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__highscore AS SELECT id, category_id, coins FROM highscore
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE highscore
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE highscore (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_id INTEGER NOT NULL, coins INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO highscore (id, player_id, coins) SELECT id, category_id, coins FROM __temp__highscore
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__highscore
        SQL);
    }
}
