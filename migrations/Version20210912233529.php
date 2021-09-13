<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210912233529 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE aid_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE aid_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE aid_aid_type (aid_id INT NOT NULL, aid_type_id INT NOT NULL, PRIMARY KEY(aid_id, aid_type_id))');
        $this->addSql('CREATE INDEX IDX_108F5068CB0C1416 ON aid_aid_type (aid_id)');
        $this->addSql('CREATE INDEX IDX_108F5068286B581 ON aid_aid_type (aid_type_id)');
        $this->addSql('ALTER TABLE aid_aid_type ADD CONSTRAINT FK_108F5068CB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_aid_type ADD CONSTRAINT FK_108F5068286B581 FOREIGN KEY (aid_type_id) REFERENCES aid_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aids DROP type');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aid_aid_type DROP CONSTRAINT FK_108F5068286B581');
        $this->addSql('DROP SEQUENCE aid_type_id_seq CASCADE');
        $this->addSql('DROP TABLE aid_type');
        $this->addSql('DROP TABLE aid_aid_type');
        $this->addSql('ALTER TABLE aids ADD type VARCHAR(255) NOT NULL');
    }
}
