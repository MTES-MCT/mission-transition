<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529180528 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aide ADD thematique_source TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE aide ADD zone_geographique_source VARCHAR(255) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN aide.thematique_source IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aide DROP thematique_source');
        $this->addSql('ALTER TABLE aide DROP zone_geographique_source');
    }
}
