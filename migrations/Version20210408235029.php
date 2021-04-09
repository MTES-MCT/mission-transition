<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408235029 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE aid_region (aid_id INT NOT NULL, region_id INT NOT NULL, PRIMARY KEY(aid_id, region_id))');
        $this->addSql('CREATE INDEX IDX_12F3570DCB0C1416 ON aid_region (aid_id)');
        $this->addSql('CREATE INDEX IDX_12F3570D98260155 ON aid_region (region_id)');
        $this->addSql('ALTER TABLE aid_region ADD CONSTRAINT FK_12F3570DCB0C1416 FOREIGN KEY (aid_id) REFERENCES aids (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aid_region ADD CONSTRAINT FK_12F3570D98260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aids DROP CONSTRAINT fk_2d4531f098260155');
        $this->addSql('DROP INDEX idx_2d4531f098260155');
        $this->addSql('ALTER TABLE aids DROP region_id');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE aid_region');
        $this->addSql('ALTER TABLE aids ADD region_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE aids ADD CONSTRAINT fk_2d4531f098260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2d4531f098260155 ON aids (region_id)');
    }
}
