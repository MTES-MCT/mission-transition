<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522103838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial database structure';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE aide_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etat_avancement_projet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE recurrence_aide_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sous_thematique_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE thematique_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_aide_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_depense_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE zone_geographique_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE aide (id INT NOT NULL, recurrence_aide_id INT DEFAULT NULL, nom_aide TEXT DEFAULT NULL, nom_aide_normalise TEXT NOT NULL, taux_subvention_minimum INT DEFAULT NULL, taux_subvention_maximum INT DEFAULT NULL, taux_subvention_commentaire TEXT DEFAULT NULL, aap_ami BOOLEAN NOT NULL, description TEXT NOT NULL, exemple_projet TEXT DEFAULT NULL, id_source VARCHAR(255) DEFAULT NULL, date_ouverture DATE DEFAULT NULL, date_pre_depot DATE DEFAULT NULL, date_cloture DATE DEFAULT NULL, conditions_eligibilite TEXT DEFAULT NULL, url_descriptif TEXT DEFAULT NULL, url_demarche TEXT DEFAULT NULL, contact TEXT DEFAULT NULL, date_mise_ajour DATE DEFAULT NULL, etat VARCHAR(255) NOT NULL, programme_aides TEXT DEFAULT NULL, porteurs_aide TEXT DEFAULT NULL, porteurs_siren TEXT DEFAULT NULL, instructeurs_aide TEXT DEFAULT NULL, beneficicaires_aide TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D99184A1311687F8 ON aide (recurrence_aide_id)');
        $this->addSql('COMMENT ON COLUMN aide.programme_aides IS \'(DC2Type:simple_array)\'');
        $this->addSql('COMMENT ON COLUMN aide.porteurs_aide IS \'(DC2Type:simple_array)\'');
        $this->addSql('COMMENT ON COLUMN aide.porteurs_siren IS \'(DC2Type:simple_array)\'');
        $this->addSql('COMMENT ON COLUMN aide.instructeurs_aide IS \'(DC2Type:simple_array)\'');
        $this->addSql('COMMENT ON COLUMN aide.beneficicaires_aide IS \'(DC2Type:simple_array)\'');
        $this->addSql('CREATE TABLE aide_type_aide (aide_id INT NOT NULL, type_aide_id INT NOT NULL, PRIMARY KEY(aide_id, type_aide_id))');
        $this->addSql('CREATE INDEX IDX_E35022E1661C0C23 ON aide_type_aide (aide_id)');
        $this->addSql('CREATE INDEX IDX_E35022E14E3D63D6 ON aide_type_aide (type_aide_id)');
        $this->addSql('CREATE TABLE aide_etat_avancement_projet (aide_id INT NOT NULL, etat_avancement_projet_id INT NOT NULL, PRIMARY KEY(aide_id, etat_avancement_projet_id))');
        $this->addSql('CREATE INDEX IDX_48D0C1D5661C0C23 ON aide_etat_avancement_projet (aide_id)');
        $this->addSql('CREATE INDEX IDX_48D0C1D557FB92F3 ON aide_etat_avancement_projet (etat_avancement_projet_id)');
        $this->addSql('CREATE TABLE aide_type_depense (aide_id INT NOT NULL, type_depense_id INT NOT NULL, PRIMARY KEY(aide_id, type_depense_id))');
        $this->addSql('CREATE INDEX IDX_50A1F3E4661C0C23 ON aide_type_depense (aide_id)');
        $this->addSql('CREATE INDEX IDX_50A1F3E45CDBC346 ON aide_type_depense (type_depense_id)');
        $this->addSql('CREATE TABLE aide_zone_geographique (aide_id INT NOT NULL, zone_geographique_id INT NOT NULL, PRIMARY KEY(aide_id, zone_geographique_id))');
        $this->addSql('CREATE INDEX IDX_626BE920661C0C23 ON aide_zone_geographique (aide_id)');
        $this->addSql('CREATE INDEX IDX_626BE920355BDC74 ON aide_zone_geographique (zone_geographique_id)');
        $this->addSql('CREATE TABLE etat_avancement_projet (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE recurrence_aide (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sous_thematique (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sous_thematique_aide (sous_thematique_id INT NOT NULL, aide_id INT NOT NULL, PRIMARY KEY(sous_thematique_id, aide_id))');
        $this->addSql('CREATE INDEX IDX_D71ACCD97A025320 ON sous_thematique_aide (sous_thematique_id)');
        $this->addSql('CREATE INDEX IDX_D71ACCD9661C0C23 ON sous_thematique_aide (aide_id)');
        $this->addSql('CREATE TABLE thematique (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE thematique_sous_thematique (thematique_id INT NOT NULL, sous_thematique_id INT NOT NULL, PRIMARY KEY(thematique_id, sous_thematique_id))');
        $this->addSql('CREATE INDEX IDX_1FABF501476556AF ON thematique_sous_thematique (thematique_id)');
        $this->addSql('CREATE INDEX IDX_1FABF5017A025320 ON thematique_sous_thematique (sous_thematique_id)');
        $this->addSql('CREATE TABLE type_aide (id INT NOT NULL, nom VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE type_depense (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE zone_geographique (id INT NOT NULL, nom VARCHAR(255) NOT NULL, couverture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE aide ADD CONSTRAINT FK_D99184A1311687F8 FOREIGN KEY (recurrence_aide_id) REFERENCES recurrence_aide (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aide_type_aide ADD CONSTRAINT FK_E35022E1661C0C23 FOREIGN KEY (aide_id) REFERENCES aide (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aide_type_aide ADD CONSTRAINT FK_E35022E14E3D63D6 FOREIGN KEY (type_aide_id) REFERENCES type_aide (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aide_etat_avancement_projet ADD CONSTRAINT FK_48D0C1D5661C0C23 FOREIGN KEY (aide_id) REFERENCES aide (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aide_etat_avancement_projet ADD CONSTRAINT FK_48D0C1D557FB92F3 FOREIGN KEY (etat_avancement_projet_id) REFERENCES etat_avancement_projet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aide_type_depense ADD CONSTRAINT FK_50A1F3E4661C0C23 FOREIGN KEY (aide_id) REFERENCES aide (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aide_type_depense ADD CONSTRAINT FK_50A1F3E45CDBC346 FOREIGN KEY (type_depense_id) REFERENCES type_depense (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aide_zone_geographique ADD CONSTRAINT FK_626BE920661C0C23 FOREIGN KEY (aide_id) REFERENCES aide (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE aide_zone_geographique ADD CONSTRAINT FK_626BE920355BDC74 FOREIGN KEY (zone_geographique_id) REFERENCES zone_geographique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sous_thematique_aide ADD CONSTRAINT FK_D71ACCD97A025320 FOREIGN KEY (sous_thematique_id) REFERENCES sous_thematique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sous_thematique_aide ADD CONSTRAINT FK_D71ACCD9661C0C23 FOREIGN KEY (aide_id) REFERENCES aide (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thematique_sous_thematique ADD CONSTRAINT FK_1FABF501476556AF FOREIGN KEY (thematique_id) REFERENCES thematique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thematique_sous_thematique ADD CONSTRAINT FK_1FABF5017A025320 FOREIGN KEY (sous_thematique_id) REFERENCES sous_thematique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE aide_type_aide DROP CONSTRAINT FK_E35022E1661C0C23');
        $this->addSql('ALTER TABLE aide_etat_avancement_projet DROP CONSTRAINT FK_48D0C1D5661C0C23');
        $this->addSql('ALTER TABLE aide_type_depense DROP CONSTRAINT FK_50A1F3E4661C0C23');
        $this->addSql('ALTER TABLE aide_zone_geographique DROP CONSTRAINT FK_626BE920661C0C23');
        $this->addSql('ALTER TABLE sous_thematique_aide DROP CONSTRAINT FK_D71ACCD9661C0C23');
        $this->addSql('ALTER TABLE aide_etat_avancement_projet DROP CONSTRAINT FK_48D0C1D557FB92F3');
        $this->addSql('ALTER TABLE aide DROP CONSTRAINT FK_D99184A1311687F8');
        $this->addSql('ALTER TABLE sous_thematique_aide DROP CONSTRAINT FK_D71ACCD97A025320');
        $this->addSql('ALTER TABLE thematique_sous_thematique DROP CONSTRAINT FK_1FABF5017A025320');
        $this->addSql('ALTER TABLE thematique_sous_thematique DROP CONSTRAINT FK_1FABF501476556AF');
        $this->addSql('ALTER TABLE aide_type_aide DROP CONSTRAINT FK_E35022E14E3D63D6');
        $this->addSql('ALTER TABLE aide_type_depense DROP CONSTRAINT FK_50A1F3E45CDBC346');
        $this->addSql('ALTER TABLE aide_zone_geographique DROP CONSTRAINT FK_626BE920355BDC74');
        $this->addSql('DROP SEQUENCE aide_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etat_avancement_projet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE recurrence_aide_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sous_thematique_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE thematique_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_aide_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_depense_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE zone_geographique_id_seq CASCADE');
        $this->addSql('DROP TABLE aide');
        $this->addSql('DROP TABLE aide_type_aide');
        $this->addSql('DROP TABLE aide_etat_avancement_projet');
        $this->addSql('DROP TABLE aide_type_depense');
        $this->addSql('DROP TABLE aide_zone_geographique');
        $this->addSql('DROP TABLE etat_avancement_projet');
        $this->addSql('DROP TABLE recurrence_aide');
        $this->addSql('DROP TABLE sous_thematique');
        $this->addSql('DROP TABLE sous_thematique_aide');
        $this->addSql('DROP TABLE thematique');
        $this->addSql('DROP TABLE thematique_sous_thematique');
        $this->addSql('DROP TABLE type_aide');
        $this->addSql('DROP TABLE type_depense');
        $this->addSql('DROP TABLE zone_geographique');
    }
}
