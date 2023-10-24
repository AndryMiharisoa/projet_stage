<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231005113533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudient ADD facultative VARCHAR(255) DEFAULT NULL, DROP faculatative, CHANGE est_verifie est_verifie TINYINT(1) DEFAULT 0 NOT NULL, CHANGE salle salle INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudient ADD faculatative VARCHAR(255) NOT NULL, DROP facultative, CHANGE est_verifie est_verifie TINYINT(1) NOT NULL, CHANGE salle salle INT NOT NULL');
    }
}
