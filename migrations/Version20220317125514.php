<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317125514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, id_room_id INTEGER NOT NULL, locator VARCHAR(255) NOT NULL, guests INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C8495579F37AE5 ON list (id_user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C849558A8AD9E3 ON list (id_room_id)');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id_id INTEGER NOT NULL, number INTEGER NOT NULL, entry_date DATETIME DEFAULT NULL, exit_date DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_729F519B714819A0 ON room (type_id_id)');
        $this->addSql('CREATE TABLE room_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(36) NOT NULL, capacity INTEGER NOT NULL, price INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(36) NOT NULL, phone VARCHAR(36) NOT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE list');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE room_type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
