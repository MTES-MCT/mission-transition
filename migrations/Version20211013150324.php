<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211013150324 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aids ALTER application_url TYPE TEXT');
        $this->addSql('ALTER TABLE aids ALTER application_url DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aids ALTER application_url TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE aids ALTER application_url DROP DEFAULT');
    }
}
