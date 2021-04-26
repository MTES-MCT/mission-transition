<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415131035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE environmental_action_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE environmental_action_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE environmental_actions ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE environmental_actions ADD CONSTRAINT FK_FC75D8A712469DE2 FOREIGN KEY (category_id) REFERENCES environmental_action_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FC75D8A712469DE2 ON environmental_actions (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE environmental_actions DROP CONSTRAINT FK_FC75D8A712469DE2');
        $this->addSql('DROP SEQUENCE environmental_action_category_id_seq CASCADE');
        $this->addSql('DROP TABLE environmental_action_category');
        $this->addSql('DROP INDEX IDX_FC75D8A712469DE2');
        $this->addSql('ALTER TABLE environmental_actions DROP category_id');
    }
}
