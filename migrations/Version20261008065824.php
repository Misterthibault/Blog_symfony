<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261008065824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE TABLE article_id (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATE NOT NULL, lieu LONGTEXT NOT NULL,  fk_user_id INT DEFAULT NULL, INDEX IDX_B26681E5741EEB9 (fk_user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        //$this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY `FK_67F068BC8F3EC46`');
        //$this->addSql('DROP INDEX IDX_67F068BC8F3EC46 ON commentaire');
        //$this->addSql('ALTER TABLE commentaire CHANGE article_id article_id_id INT DEFAULT NULL');
        //$this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        //$this->addSql('CREATE INDEX IDX_67F068BC8F3EC46 ON commentaire (article_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E5741EEB9');
        //$this->addSql('DROP TABLE article_id');
        $this->addSql('DROP TABLE evenement');
        //$this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC8F3EC46');
        //$this->addSql('DROP INDEX IDX_67F068BC8F3EC46 ON commentaire');
        //$this->addSql('ALTER TABLE commentaire CHANGE article_id_id article_id INT DEFAULT NULL');
        //$this->addSql('ALTER TABLE commentaire ADD CONSTRAINT `FK_67F068BC8F3EC46` FOREIGN KEY (article_id) REFERENCES article (id)');
        //$this->addSql('CREATE INDEX IDX_67F068BC8F3EC46 ON commentaire (article_id)');
    }
}
