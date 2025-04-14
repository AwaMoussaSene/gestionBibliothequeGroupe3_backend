<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414143844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, profession VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE auteur_ouvrage (id INT AUTO_INCREMENT NOT NULL, auteur_id INT DEFAULT NULL, ouvrage_id INT DEFAULT NULL, INDEX IDX_EC8A08BD60BB6FE6 (auteur_id), INDEX IDX_EC8A08BD15D884B5 (ouvrage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE exemplaire (id INT AUTO_INCREMENT NOT NULL, rayon_id INT NOT NULL, ouvrage_id INT DEFAULT NULL, code_exemplaire VARCHAR(255) NOT NULL, date_enregistrement DATE NOT NULL, archiver VARCHAR(255) NOT NULL, qte INT NOT NULL, INDEX IDX_5EF83C92D3202E52 (rayon_id), INDEX IDX_5EF83C9215D884B5 (ouvrage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE mot_cle (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE mot_cle_ouvrage (id INT AUTO_INCREMENT NOT NULL, ouvrage_id INT DEFAULT NULL, mot_cle_id INT DEFAULT NULL, INDEX IDX_D0D3F95815D884B5 (ouvrage_id), INDEX IDX_D0D3F958FE94535C (mot_cle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ouvrage (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, date_edition DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pret (id INT AUTO_INCREMENT NOT NULL, exemplaire_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_demande DATE NOT NULL, date_pret DATE NOT NULL, date_retour DATE NOT NULL, date_retour_reel DATE NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_52ECE9795843AA21 (exemplaire_id), INDEX IDX_52ECE979A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE rayon (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, mdp VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auteur_ouvrage ADD CONSTRAINT FK_EC8A08BD60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auteur_ouvrage ADD CONSTRAINT FK_EC8A08BD15D884B5 FOREIGN KEY (ouvrage_id) REFERENCES ouvrage (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C92D3202E52 FOREIGN KEY (rayon_id) REFERENCES rayon (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C9215D884B5 FOREIGN KEY (ouvrage_id) REFERENCES ouvrage (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_ouvrage ADD CONSTRAINT FK_D0D3F95815D884B5 FOREIGN KEY (ouvrage_id) REFERENCES ouvrage (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_ouvrage ADD CONSTRAINT FK_D0D3F958FE94535C FOREIGN KEY (mot_cle_id) REFERENCES mot_cle (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pret ADD CONSTRAINT FK_52ECE9795843AA21 FOREIGN KEY (exemplaire_id) REFERENCES exemplaire (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pret ADD CONSTRAINT FK_52ECE979A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE auteur_ouvrage DROP FOREIGN KEY FK_EC8A08BD60BB6FE6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auteur_ouvrage DROP FOREIGN KEY FK_EC8A08BD15D884B5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C92D3202E52
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C9215D884B5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_ouvrage DROP FOREIGN KEY FK_D0D3F95815D884B5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_ouvrage DROP FOREIGN KEY FK_D0D3F958FE94535C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pret DROP FOREIGN KEY FK_52ECE9795843AA21
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pret DROP FOREIGN KEY FK_52ECE979A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auteur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auteur_ouvrage
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE exemplaire
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE mot_cle
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE mot_cle_ouvrage
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ouvrage
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE personne
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pret
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE rayon
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
