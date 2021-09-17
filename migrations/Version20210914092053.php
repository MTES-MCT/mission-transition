<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914092053 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE admins_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE aid_advisors_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE aid_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE aids_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE business_activity_areas_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE environmental_action_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE environmental_actions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE environmental_topic_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE environmental_topics_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE funders_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE region_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE admins (id INT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, permissions TEXT DEFAULT NULL, is_super_admin BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A2E0150FE7927C74 ON admins (email)');
        $this->addSql('COMMENT ON COLUMN admins.permissions IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE aid_advisors (id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE aid_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE aids (id INT NOT NULL, aid_advisor_id INT DEFAULT NULL, funder_id INT DEFAULT NULL, ulid UUID NOT NULL, source_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, perimeter VARCHAR(255) DEFAULT NULL, goal TEXT DEFAULT NULL, beneficiary TEXT DEFAULT NULL, aid_details TEXT DEFAULT NULL, eligibility TEXT DEFAULT NULL, conditions TEXT DEFAULT NULL, funding_source_url TEXT DEFAULT NULL, application_end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, application_url VARCHAR(255) DEFAULT NULL, state VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, funding_types TEXT DEFAULT NULL, contact_guidelines TEXT DEFAULT NULL, source_updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, subvention_rate_upper_bound INT DEFAULT NULL, subvention_rate_lower_bound INT DEFAULT NULL, loan_amount INT DEFAULT NULL, application_start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, project_examples TEXT DEFAULT NULL, direct_access BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D4531F0C288C859 ON aids (ulid)');
        $this->addSql('CREATE INDEX IDX_2D4531F0C447CBA ON aids (aid_advisor_id)');
        $this->addSql('CREATE INDEX IDX_2D4531F06CC88588 ON aids (funder_id)');
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
        $this->addSql('CREATE TABLE aid_region (aid_id INT NOT NULL, region_id INT NOT NULL, PRIMARY KEY(aid_id, region_id))');
        $this->addSql('CREATE INDEX IDX_12F3570DCB0C1416 ON aid_region (aid_id)');
        $this->addSql('CREATE INDEX IDX_12F3570D98260155 ON aid_region (region_id)');
        $this->addSql('CREATE TABLE aid_aid_type (aid_id INT NOT NULL, aid_type_id INT NOT NULL, PRIMARY KEY(aid_id, aid_type_id))');
        $this->addSql('CREATE INDEX IDX_108F5068CB0C1416 ON aid_aid_type (aid_id)');
        $this->addSql('CREATE INDEX IDX_108F5068286B581 ON aid_aid_type (aid_type_id)');
        $this->addSql('CREATE TABLE business_activity_areas (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE environmental_action_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE environmental_actions (id INT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FC75D8A712469DE2 ON environmental_actions (category_id)');
        $this->addSql('CREATE TABLE environmental_topic_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE environmental_topic_category_environmental_topic (environmental_topic_category_id INT NOT NULL, environmental_topic_id INT NOT NULL, PRIMARY KEY(environmental_topic_category_id, environmental_topic_id))');
        $this->addSql('CREATE INDEX IDX_ECE3F22585294D90 ON environmental_topic_category_environmental_topic (environmental_topic_category_id)');
        $this->addSql('CREATE INDEX IDX_ECE3F22567ABD4B6 ON environmental_topic_category_environmental_topic (environmental_topic_id)');
        $this->addSql('CREATE TABLE environmental_topics (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE funders (id INT NOT NULL, name VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE region (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE aids ADD CONSTRAINT FK_2D4531F0C447CBA FOREIGN KEY (aid_advisor_id) REFERENCES aid_advisors (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aids ADD CONSTRAINT FK_2D4531F06CC88588 FOREIGN KEY (funder_id) REFERENCES funders (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_environmental_action ADD CONSTRAINT FK_4784D526CB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_environmental_action ADD CONSTRAINT FK_4784D526E7205469 FOREIGN KEY (environmental_action_id) REFERENCES environmental_actions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_environmental_topic ADD CONSTRAINT FK_D5196A1BCB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_environmental_topic ADD CONSTRAINT FK_D5196A1B67ABD4B6 FOREIGN KEY (environmental_topic_id) REFERENCES environmental_topics (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_business_activity_area ADD CONSTRAINT FK_6C9B5ACECB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_business_activity_area ADD CONSTRAINT FK_6C9B5ACE3087BC3B FOREIGN KEY (business_activity_area_id) REFERENCES business_activity_areas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_region ADD CONSTRAINT FK_12F3570DCB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_region ADD CONSTRAINT FK_12F3570D98260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_aid_type ADD CONSTRAINT FK_108F5068CB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_aid_type ADD CONSTRAINT FK_108F5068286B581 FOREIGN KEY (aid_type_id) REFERENCES aid_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE environmental_actions ADD CONSTRAINT FK_FC75D8A712469DE2 FOREIGN KEY (category_id) REFERENCES environmental_action_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE environmental_topic_category_environmental_topic ADD CONSTRAINT FK_ECE3F22585294D90 FOREIGN KEY (environmental_topic_category_id) REFERENCES environmental_topic_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE environmental_topic_category_environmental_topic ADD CONSTRAINT FK_ECE3F22567ABD4B6 FOREIGN KEY (environmental_topic_id) REFERENCES environmental_topics (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aids DROP CONSTRAINT FK_2D4531F0C447CBA');
        $this->addSql('ALTER TABLE aid_aid_type DROP CONSTRAINT FK_108F5068286B581');
        $this->addSql('ALTER TABLE aid_environmental_action DROP CONSTRAINT FK_4784D526CB0C1416');
        $this->addSql('ALTER TABLE aid_environmental_topic DROP CONSTRAINT FK_D5196A1BCB0C1416');
        $this->addSql('ALTER TABLE aid_business_activity_area DROP CONSTRAINT FK_6C9B5ACECB0C1416');
        $this->addSql('ALTER TABLE aid_region DROP CONSTRAINT FK_12F3570DCB0C1416');
        $this->addSql('ALTER TABLE aid_aid_type DROP CONSTRAINT FK_108F5068CB0C1416');
        $this->addSql('ALTER TABLE aid_business_activity_area DROP CONSTRAINT FK_6C9B5ACE3087BC3B');
        $this->addSql('ALTER TABLE environmental_actions DROP CONSTRAINT FK_FC75D8A712469DE2');
        $this->addSql('ALTER TABLE aid_environmental_action DROP CONSTRAINT FK_4784D526E7205469');
        $this->addSql('ALTER TABLE environmental_topic_category_environmental_topic DROP CONSTRAINT FK_ECE3F22585294D90');
        $this->addSql('ALTER TABLE aid_environmental_topic DROP CONSTRAINT FK_D5196A1B67ABD4B6');
        $this->addSql('ALTER TABLE environmental_topic_category_environmental_topic DROP CONSTRAINT FK_ECE3F22567ABD4B6');
        $this->addSql('ALTER TABLE aids DROP CONSTRAINT FK_2D4531F06CC88588');
        $this->addSql('ALTER TABLE aid_region DROP CONSTRAINT FK_12F3570D98260155');
        $this->addSql('DROP SEQUENCE admins_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE aid_advisors_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE aid_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE aids_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE business_activity_areas_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE environmental_action_category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE environmental_actions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE environmental_topic_category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE environmental_topics_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE funders_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE region_id_seq CASCADE');
        $this->addSql('DROP TABLE admins');
        $this->addSql('DROP TABLE aid_advisors');
        $this->addSql('DROP TABLE aid_type');
        $this->addSql('DROP TABLE aids');
        $this->addSql('DROP TABLE aid_environmental_action');
        $this->addSql('DROP TABLE aid_environmental_topic');
        $this->addSql('DROP TABLE aid_business_activity_area');
        $this->addSql('DROP TABLE aid_region');
        $this->addSql('DROP TABLE aid_aid_type');
        $this->addSql('DROP TABLE business_activity_areas');
        $this->addSql('DROP TABLE environmental_action_category');
        $this->addSql('DROP TABLE environmental_actions');
        $this->addSql('DROP TABLE environmental_topic_category');
        $this->addSql('DROP TABLE environmental_topic_category_environmental_topic');
        $this->addSql('DROP TABLE environmental_topics');
        $this->addSql('DROP TABLE funders');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
