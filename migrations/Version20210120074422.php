<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210120074422 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offres ADD auteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC354460BB6FE6 FOREIGN KEY (auteur_id) REFERENCES recruteur (id)');
        $this->addSql('CREATE INDEX IDX_C6AC354460BB6FE6 ON offres (auteur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offres DROP FOREIGN KEY FK_C6AC354460BB6FE6');
        $this->addSql('DROP INDEX IDX_C6AC354460BB6FE6 ON offres');
        $this->addSql('ALTER TABLE offres DROP auteur_id');
    }
}
