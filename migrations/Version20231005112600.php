<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231005112600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE centre (id INT AUTO_INCREMENT NOT NULL, etudient_id INT DEFAULT NULL, salle_id INT NOT NULL, nom_centre VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, INDEX IDX_C6A0EA75467BF3B5 (etudient_id), INDEX IDX_C6A0EA75DC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, etablissement VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, serie VARCHAR(255) NOT NULL, est_verifie TINYINT(1) NOT NULL, salle INT NOT NULL, faculatative VARCHAR(255) NOT NULL, collective VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, note_id_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, coefficient SMALLINT NOT NULL, UNIQUE INDEX UNIQ_9014574A1A543D80 (note_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, etudient_id INT DEFAULT NULL, valeur INT NOT NULL, INDEX IDX_CFBDFA14467BF3B5 (etudient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE centre ADD CONSTRAINT FK_C6A0EA75467BF3B5 FOREIGN KEY (etudient_id) REFERENCES etudient (id)');
        $this->addSql('ALTER TABLE centre ADD CONSTRAINT FK_C6A0EA75DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A1A543D80 FOREIGN KEY (note_id_id) REFERENCES note (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14467BF3B5 FOREIGN KEY (etudient_id) REFERENCES etudient (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centre DROP FOREIGN KEY FK_C6A0EA75467BF3B5');
        $this->addSql('ALTER TABLE centre DROP FOREIGN KEY FK_C6A0EA75DC304035');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A1A543D80');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14467BF3B5');
        $this->addSql('DROP TABLE centre');
        $this->addSql('DROP TABLE etudient');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
