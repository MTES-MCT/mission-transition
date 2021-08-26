<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210811132750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aids ADD contact_guidelines TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE aids ADD source_updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE aids ADD subvention_rate_upper_bound INT DEFAULT NULL');
        $this->addSql('ALTER TABLE aids ADD subvention_rate_lower_bound INT DEFAULT NULL');
        $this->addSql('ALTER TABLE aids ADD loan_amount INT DEFAULT NULL');
        $this->addSql('ALTER TABLE aids ADD application_start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE aids DROP contact_guidelines');
        $this->addSql('ALTER TABLE aids DROP source_updated_at');
        $this->addSql('ALTER TABLE aids DROP subvention_rate_upper_bound');
        $this->addSql('ALTER TABLE aids DROP subvention_rate_lower_bound');
        $this->addSql('ALTER TABLE aids DROP loan_amount');
        $this->addSql('ALTER TABLE aids DROP application_start_date');
    }
}
