<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408162702 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aid_advisors ADD address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE aid_advisors ADD description TEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aid_advisors DROP address');
        $this->addSql('ALTER TABLE aid_advisors DROP description');
    }
}
