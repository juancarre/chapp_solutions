<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317131215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_42C849558A8AD9E3');
        $this->addSql('DROP INDEX UNIQ_42C8495579F37AE5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, id_user_id, id_room_id, locator, guests FROM list');
        $this->addSql('DROP TABLE list');
        $this->addSql('CREATE TABLE list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, id_room_id INTEGER NOT NULL, locator VARCHAR(255) NOT NULL, guests INTEGER NOT NULL, CONSTRAINT FK_42C8495579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_42C849558A8AD9E3 FOREIGN KEY (id_room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO list (id, id_user_id, id_room_id, locator, guests) SELECT id, id_user_id, id_room_id, locator, guests FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C849558A8AD9E3 ON list (id_room_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C8495579F37AE5 ON list (id_user_id)');
        $this->addSql('DROP INDEX IDX_729F519B714819A0');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, type_id_id, entry_date, exit_date FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id_id INTEGER NOT NULL, entry_date DATETIME DEFAULT NULL, exit_date DATETIME DEFAULT NULL, CONSTRAINT FK_729F519B714819A0 FOREIGN KEY (type_id_id) REFERENCES room_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room (id, type_id_id, entry_date, exit_date) SELECT id, type_id_id, entry_date, exit_date FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B714819A0 ON room (type_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_42C8495579F37AE5');
        $this->addSql('DROP INDEX UNIQ_42C849558A8AD9E3');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, id_user_id, id_room_id, locator, guests FROM list');
        $this->addSql('DROP TABLE list');
        $this->addSql('CREATE TABLE list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, id_room_id INTEGER NOT NULL, locator VARCHAR(255) NOT NULL, guests INTEGER NOT NULL)');
        $this->addSql('INSERT INTO list (id, id_user_id, id_room_id, locator, guests) SELECT id, id_user_id, id_room_id, locator, guests FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C8495579F37AE5 ON list (id_user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C849558A8AD9E3 ON list (id_room_id)');
        $this->addSql('DROP INDEX IDX_729F519B714819A0');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, type_id_id, entry_date, exit_date FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id_id INTEGER NOT NULL, entry_date DATETIME DEFAULT NULL, exit_date DATETIME DEFAULT NULL, number INTEGER NOT NULL)');
        $this->addSql('INSERT INTO room (id, type_id_id, entry_date, exit_date) SELECT id, type_id_id, entry_date, exit_date FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B714819A0 ON room (type_id_id)');
    }
}
