<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210110170405 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, birth VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, avatar VARCHAR(255) DEFAULT NULL, documents VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, offre_id INT NOT NULL, candidat_id INT NOT NULL, INDEX IDX_8933C4324CC8505A (offre_id), INDEX IDX_8933C4328D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offres (id INT AUTO_INCREMENT NOT NULL, naame VARCHAR(255) DEFAULT NULL, entreprise VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL, secteur VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, contrat VARCHAR(255) NOT NULL, disponible VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL, logo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4324CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4328D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4328D0EB82');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4324CC8505A');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE offres');
    }
}
