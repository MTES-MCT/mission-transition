<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325105629 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE aid_advisors_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE aids_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE business_activity_areas_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE environmental_actions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE environmental_topics_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE funders_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE region_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE aid_advisors (id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE aids (id INT NOT NULL, aid_advisor_id INT DEFAULT NULL, funder_id INT DEFAULT NULL, region_id INT DEFAULT NULL, ulid UUID NOT NULL, source_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, perimeter VARCHAR(255) DEFAULT NULL, goal TEXT DEFAULT NULL, beneficiary TEXT DEFAULT NULL, aid_details TEXT DEFAULT NULL, eligibility TEXT DEFAULT NULL, conditions TEXT DEFAULT NULL, funding_source_url VARCHAR(255) DEFAULT NULL, application_end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, application_url VARCHAR(255) DEFAULT NULL, state VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, funding_types TEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D4531F0C288C859 ON aids (ulid)');
        $this->addSql('CREATE INDEX IDX_2D4531F0C447CBA ON aids (aid_advisor_id)');
        $this->addSql('CREATE INDEX IDX_2D4531F06CC88588 ON aids (funder_id)');
        $this->addSql('CREATE INDEX IDX_2D4531F098260155 ON aids (region_id)');
        $this->addSql('COMMENT ON COLUMN aids.ulid IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN aids.funding_types IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE aid_environmental_action (aid_id INT NOT NULL, environmental_action_id INT NOT NULL, PRIMARY KEY(aid_id, environmental_action_id))');
        $this->addSql('CREATE INDEX IDX_4784D526CB0C1416 ON aid_environmental_action (aid_id)');
        $this->addSql('CREATE INDEX IDX_4784D526E7205469 ON aid_environmental_action (environmental_action_id)');
        $this->addSql('CREATE TABLE aid_environmental_topic (aid_id INT NOT NULL, environmental_topic_id INT NOT NULL, PRIMARY KEY(aid_id, environmental_topic_id))');
        $this->addSql('CREATE INDEX IDX_D5196A1BCB0C1416 ON aid_environmental_topic (aid_id)');
        $this->addSql('CREATE INDEX IDX_D5196A1B67ABD4B6 ON aid_environmental_topic (environmental_topic_id)');
        $this->addSql('CREATE TABLE aid_business_activity_area (aid_id INT NOT NULL, business_activity_area_id INT NOT NULL, PRIMARY KEY(aid_id, business_activity_area_id))');
        $this->addSql('CREATE INDEX IDX_6C9B5ACECB0C1416 ON aid_business_activity_area (aid_id)');
        $this->addSql('CREATE INDEX IDX_6C9B5ACE3087BC3B ON aid_business_activity_area (business_activity_area_id)');
        $this->addSql('CREATE TABLE business_activity_areas (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE environmental_actions (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE environmental_topics (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE funders (id INT NOT NULL, name VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE region (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE aids ADD CONSTRAINT FK_2D4531F0C447CBA FOREIGN KEY (aid_advisor_id) REFERENCES aid_advisors (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aids ADD CONSTRAINT FK_2D4531F06CC88588 FOREIGN KEY (funder_id) REFERENCES funders (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aids ADD CONSTRAINT FK_2D4531F098260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_environmental_action ADD CONSTRAINT FK_4784D526CB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_environmental_action ADD CONSTRAINT FK_4784D526E7205469 FOREIGN KEY (environmental_action_id) REFERENCES environmental_actions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_environmental_topic ADD CONSTRAINT FK_D5196A1BCB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_environmental_topic ADD CONSTRAINT FK_D5196A1B67ABD4B6 FOREIGN KEY (environmental_topic_id) REFERENCES environmental_topics (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_business_activity_area ADD CONSTRAINT FK_6C9B5ACECB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_business_activity_area ADD CONSTRAINT FK_6C9B5ACE3087BC3B FOREIGN KEY (business_activity_area_id) REFERENCES business_activity_areas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aids DROP CONSTRAINT FK_2D4531F0C447CBA');
        $this->addSql('ALTER TABLE aid_environmental_action DROP CONSTRAINT FK_4784D526CB0C1416');
        $this->addSql('ALTER TABLE aid_environmental_topic DROP CONSTRAINT FK_D5196A1BCB0C1416');
        $this->addSql('ALTER TABLE aid_business_activity_area DROP CONSTRAINT FK_6C9B5ACECB0C1416');
        $this->addSql('ALTER TABLE aid_business_activity_area DROP CONSTRAINT FK_6C9B5ACE3087BC3B');
        $this->addSql('ALTER TABLE aid_environmental_action DROP CONSTRAINT FK_4784D526E7205469');
        $this->addSql('ALTER TABLE aid_environmental_topic DROP CONSTRAINT FK_D5196A1B67ABD4B6');
        $this->addSql('ALTER TABLE aids DROP CONSTRAINT FK_2D4531F06CC88588');
        $this->addSql('ALTER TABLE aids DROP CONSTRAINT FK_2D4531F098260155');
        $this->addSql('DROP SEQUENCE aid_advisors_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE aids_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE business_activity_areas_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE environmental_actions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE environmental_topics_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE funders_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE region_id_seq CASCADE');
        $this->addSql('DROP TABLE aid_advisors');
        $this->addSql('DROP TABLE aids');
        $this->addSql('DROP TABLE aid_environmental_action');
        $this->addSql('DROP TABLE aid_environmental_topic');
        $this->addSql('DROP TABLE aid_business_activity_area');
        $this->addSql('DROP TABLE business_activity_areas');
        $this->addSql('DROP TABLE environmental_actions');
        $this->addSql('DROP TABLE environmental_topics');
        $this->addSql('DROP TABLE funders');
        $this->addSql('DROP TABLE region');
    }
}
