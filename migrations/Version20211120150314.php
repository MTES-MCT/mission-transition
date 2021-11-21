<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211120150314 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aids DROP CONSTRAINT fk_2d4531f0c447cba');
        $this->addSql('ALTER TABLE aid_environmental_action DROP CONSTRAINT fk_4784d526e7205469');
        $this->addSql('ALTER TABLE environmental_actions DROP CONSTRAINT fk_fc75d8a712469de2');
        $this->addSql('DROP SEQUENCE aid_advisors_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE environmental_action_category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE environmental_actions_id_seq CASCADE');
        $this->addSql('DROP TABLE aid_advisors');
        $this->addSql('DROP TABLE aid_environmental_action');
        $this->addSql('DROP TABLE environmental_actions');
        $this->addSql('DROP TABLE environmental_action_category');
        $this->addSql('DROP INDEX idx_2d4531f0c447cba');
        $this->addSql('ALTER TABLE aids DROP aid_advisor_id');
        $this->addSql('ALTER TABLE aids DROP goal');
        $this->addSql('ALTER TABLE aids DROP beneficiary');
        $this->addSql('ALTER TABLE aids DROP conditions');
        $this->addSql('ALTER TABLE messenger_messages ALTER queue_name TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE aid_advisors_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE environmental_action_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE environmental_actions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE aid_advisors (id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE aid_environmental_action (aid_id INT NOT NULL, environmental_action_id INT NOT NULL, PRIMARY KEY(aid_id, environmental_action_id))');
        $this->addSql('CREATE INDEX idx_4784d526e7205469 ON aid_environmental_action (environmental_action_id)');
        $this->addSql('CREATE INDEX idx_4784d526cb0c1416 ON aid_environmental_action (aid_id)');
        $this->addSql('CREATE TABLE environmental_actions (id INT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_fc75d8a712469de2 ON environmental_actions (category_id)');
        $this->addSql('CREATE TABLE environmental_action_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE aid_environmental_action ADD CONSTRAINT fk_4784d526cb0c1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_environmental_action ADD CONSTRAINT fk_4784d526e7205469 FOREIGN KEY (environmental_action_id) REFERENCES environmental_actions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE environmental_actions ADD CONSTRAINT fk_fc75d8a712469de2 FOREIGN KEY (category_id) REFERENCES environmental_action_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messenger_messages ALTER queue_name TYPE VARCHAR(190)');
        $this->addSql('ALTER TABLE aids ADD aid_advisor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE aids ADD goal TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE aids ADD beneficiary TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE aids ADD conditions TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE aids ADD CONSTRAINT fk_2d4531f0c447cba FOREIGN KEY (aid_advisor_id) REFERENCES aid_advisors (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2d4531f0c447cba ON aids (aid_advisor_id)');
    }
}
