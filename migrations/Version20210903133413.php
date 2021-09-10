<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210903133413 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE environmental_topic_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE environmental_topic_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE environmental_topic_category_environmental_topic (environmental_topic_category_id INT NOT NULL, environmental_topic_id INT NOT NULL, PRIMARY KEY(environmental_topic_category_id, environmental_topic_id))');
        $this->addSql('CREATE INDEX IDX_ECE3F22585294D90 ON environmental_topic_category_environmental_topic (environmental_topic_category_id)');
        $this->addSql('CREATE INDEX IDX_ECE3F22567ABD4B6 ON environmental_topic_category_environmental_topic (environmental_topic_id)');
        $this->addSql('ALTER TABLE environmental_topic_category_environmental_topic ADD CONSTRAINT FK_ECE3F22585294D90 FOREIGN KEY (environmental_topic_category_id) REFERENCES environmental_topic_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE environmental_topic_category_environmental_topic ADD CONSTRAINT FK_ECE3F22567ABD4B6 FOREIGN KEY (environmental_topic_id) REFERENCES environmental_topics (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aids ALTER direct_access DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE environmental_topic_category_environmental_topic DROP CONSTRAINT FK_ECE3F22585294D90');
        $this->addSql('DROP SEQUENCE environmental_topic_category_id_seq CASCADE');
        $this->addSql('DROP TABLE environmental_topic_category');
        $this->addSql('DROP TABLE environmental_topic_category_environmental_topic');
        $this->addSql('ALTER TABLE aids ALTER direct_access SET DEFAULT \'false\'');
    }
}
