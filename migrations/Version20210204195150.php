<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204195150 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE action_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE action (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, cta VARCHAR(255) DEFAULT NULL, cta_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE categories (id INT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, lft INT NOT NULL, level INT NOT NULL, rgt INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3AF34668A977936C ON categories (tree_root)');
        $this->addSql('CREATE INDEX IDX_3AF34668727ACA70 ON categories (parent_id)');
        $this->addSql('CREATE TABLE fundraising_card (id UUID NOT NULL, source_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, source_name VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, state VARCHAR(255) NOT NULL, source_url VARCHAR(255) DEFAULT NULL, eligibility TEXT DEFAULT NULL, funder_name VARCHAR(255) DEFAULT NULL, funding_amount VARCHAR(255) DEFAULT NULL, application_end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, application_url VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN fundraising_card.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668A977936C FOREIGN KEY (tree_root) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT FK_3AF34668A977936C');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT FK_3AF34668727ACA70');
        $this->addSql('DROP SEQUENCE action_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE fundraising_card');
        $this->addSql('DROP TABLE tag');
    }
}
