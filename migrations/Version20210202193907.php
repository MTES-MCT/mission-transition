<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202193907 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE admins_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE admins (id INT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, permissions TEXT DEFAULT NULL, is_super_admin BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A2E0150FE7927C74 ON admins (email)');
        $this->addSql('COMMENT ON COLUMN admins.permissions IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('BEGIN;');
        $this->addSql('LOCK TABLE messenger_messages;');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('COMMIT;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE admins_id_seq CASCADE');
        $this->addSql('DROP TABLE admins');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
