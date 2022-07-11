<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711111910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE admin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE admin_id_seq CASCADE');
    }
}
