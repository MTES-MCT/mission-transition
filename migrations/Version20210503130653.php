<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210503130653 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE aids ALTER funding_source_url TYPE TEXT');
        $this->addSql('ALTER TABLE aids ALTER funding_source_url DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE aids ALTER funding_source_url TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE aids ALTER funding_source_url DROP DEFAULT');
    }
}
