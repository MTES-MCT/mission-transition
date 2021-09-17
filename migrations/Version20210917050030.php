<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210917050030 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE aid_feedback_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE aid_feedback (id INT NOT NULL, aid_id INT NOT NULL, was_useful BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2157FF29CB0C1416 ON aid_feedback (aid_id)');
        $this->addSql('ALTER TABLE aid_feedback ADD CONSTRAINT FK_2157FF29CB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE aid_feedback_id_seq CASCADE');
        $this->addSql('DROP TABLE aid_feedback');
    }
}
