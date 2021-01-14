<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113140907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE upload (id INT AUTO_INCREMENT NOT NULL, candidat_id INT NOT NULL, candidature_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, chemein VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_17BDE61F8D0EB82 (candidat_id), INDEX IDX_17BDE61FB6121583 (candidature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE upload ADD CONSTRAINT FK_17BDE61F8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE upload ADD CONSTRAINT FK_17BDE61FB6121583 FOREIGN KEY (candidature_id) REFERENCES candidature (id)');
        $this->addSql('ALTER TABLE recruteur ADD connexion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recruteur ADD CONSTRAINT FK_2BD3678C8D566613 FOREIGN KEY (connexion_id) REFERENCES connection (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2BD3678C8D566613 ON recruteur (connexion_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE upload');
        $this->addSql('ALTER TABLE recruteur DROP FOREIGN KEY FK_2BD3678C8D566613');
        $this->addSql('DROP INDEX UNIQ_2BD3678C8D566613 ON recruteur');
        $this->addSql('ALTER TABLE recruteur DROP connexion_id');
    }
}
