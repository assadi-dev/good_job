<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210217005251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE candidat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE candidature_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE connection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE favoris_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offres_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE recruteur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE upload_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE candidat (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, birth VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, avatar VARCHAR(255) DEFAULT NULL, documents VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE candidature (id INT NOT NULL, offre_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, recruteur_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, documents VARCHAR(255) DEFAULT NULL, reponse VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E33BD3B84CC8505A ON candidature (offre_id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B88D0EB82 ON candidature (candidat_id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B8BB0859F1 ON candidature (recruteur_id)');
        $this->addSql('CREATE TABLE connection (id INT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE favoris (id INT NOT NULL, offre_id INT NOT NULL, candidat_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8933C4324CC8505A ON favoris (offre_id)');
        $this->addSql('CREATE INDEX IDX_8933C4328D0EB82 ON favoris (candidat_id)');
        $this->addSql('CREATE TABLE offres (id INT NOT NULL, auteur_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, entreprise VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL, secteur VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, contrat VARCHAR(255) NOT NULL, disponible VARCHAR(255) NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, logo VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C6AC354460BB6FE6 ON offres (auteur_id)');
        $this->addSql('CREATE TABLE recruteur (id INT NOT NULL, connexion_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, birth VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, entreprise VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2BD3678C8D566613 ON recruteur (connexion_id)');
        $this->addSql('CREATE TABLE upload (id INT NOT NULL, candidat_id INT NOT NULL, candidature_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, chemin VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_17BDE61F8D0EB82 ON upload (candidat_id)');
        $this->addSql('CREATE INDEX IDX_17BDE61FB6121583 ON upload (candidature_id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B88D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8BB0859F1 FOREIGN KEY (recruteur_id) REFERENCES recruteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4324CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4328D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC354460BB6FE6 FOREIGN KEY (auteur_id) REFERENCES recruteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recruteur ADD CONSTRAINT FK_2BD3678C8D566613 FOREIGN KEY (connexion_id) REFERENCES connection (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE upload ADD CONSTRAINT FK_17BDE61F8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE upload ADD CONSTRAINT FK_17BDE61FB6121583 FOREIGN KEY (candidature_id) REFERENCES candidature (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE candidature DROP CONSTRAINT FK_E33BD3B88D0EB82');
        $this->addSql('ALTER TABLE favoris DROP CONSTRAINT FK_8933C4328D0EB82');
        $this->addSql('ALTER TABLE upload DROP CONSTRAINT FK_17BDE61F8D0EB82');
        $this->addSql('ALTER TABLE upload DROP CONSTRAINT FK_17BDE61FB6121583');
        $this->addSql('ALTER TABLE recruteur DROP CONSTRAINT FK_2BD3678C8D566613');
        $this->addSql('ALTER TABLE candidature DROP CONSTRAINT FK_E33BD3B84CC8505A');
        $this->addSql('ALTER TABLE favoris DROP CONSTRAINT FK_8933C4324CC8505A');
        $this->addSql('ALTER TABLE candidature DROP CONSTRAINT FK_E33BD3B8BB0859F1');
        $this->addSql('ALTER TABLE offres DROP CONSTRAINT FK_C6AC354460BB6FE6');
        $this->addSql('DROP SEQUENCE candidat_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE candidature_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE connection_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE favoris_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offres_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE recruteur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE upload_id_seq CASCADE');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE connection');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE offres');
        $this->addSql('DROP TABLE recruteur');
        $this->addSql('DROP TABLE upload');
    }
}
