<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190210201326 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, compteur_id INT DEFAULT NULL, contrat VARCHAR(255) NOT NULL, date_ab DATE NOT NULL, cumul_anc NUMERIC(10, 5) NOT NULL, cumul_nouv NUMERIC(10, 5) NOT NULL, UNIQUE INDEX UNIQ_351268BBAA3B9810 (compteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compteur (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, abonnement_id INT DEFAULT NULL, mois VARCHAR(255) NOT NULL, consommation NUMERIC(10, 5) NOT NULL, prix INT NOT NULL, reglement TINYINT(1) NOT NULL, INDEX IDX_FE866410F1D74413 (abonnement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBAA3B9810 FOREIGN KEY (compteur_id) REFERENCES compteur (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410F1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410F1D74413');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBAA3B9810');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE compteur');
        $this->addSql('DROP TABLE facture');
    }
}
