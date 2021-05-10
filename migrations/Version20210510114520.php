<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210510114520 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article_categorie ADD CONSTRAINT FK_93488610CD8737FA FOREIGN KEY (Article) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article_categorie ADD CONSTRAINT FK_93488610CB8C5497 FOREIGN KEY (Categorie) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146404021BF FOREIGN KEY (formation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634727ACA70 FOREIGN KEY (parent_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE commantaire ADD CONSTRAINT FK_93BF4CAF23A0E66 FOREIGN KEY (article) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commantaire ADD CONSTRAINT FK_93BF4CAF727ACA70 FOREIGN KEY (parent_id) REFERENCES commantaire (id)');
        $this->addSql('ALTER TABLE condidature ADD CONSTRAINT FK_FDF2E30BC1003072 FOREIGN KEY (Offres) REFERENCES offres (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5404021BF FOREIGN KEY (formation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE element_devis ADD CONSTRAINT FK_4F05B1B24AE6EA2F FOREIGN KEY (Devis) REFERENCES devis (id)');
        $this->addSql('ALTER TABLE element_devis ADD CONSTRAINT FK_4F05B1B28A44833F FOREIGN KEY (Services) REFERENCES services (id)');
        $this->addSql('ALTER TABLE element_menu ADD CONSTRAINT FK_3E3B1B6ADD3795AD FOREIGN KEY (Menu) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE element_menu ADD CONSTRAINT FK_3E3B1B6AB438191E FOREIGN KEY (Page) REFERENCES page (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E404021BF FOREIGN KEY (formation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF8D93D649');
        $this->addSql('DROP INDEX IDX_404021BF8D93D649 ON formation');
        $this->addSql('ALTER TABLE formation DROP user');
        $this->addSql('ALTER TABLE formation_page ADD CONSTRAINT FK_43D55360B438191E FOREIGN KEY (Page) REFERENCES page (id)');
        $this->addSql('ALTER TABLE formation_page ADD CONSTRAINT FK_43D55360C2B1A31C FOREIGN KEY (Formation) REFERENCES formation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article_categorie DROP FOREIGN KEY FK_93488610CD8737FA');
        $this->addSql('ALTER TABLE article_categorie DROP FOREIGN KEY FK_93488610CB8C5497');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146404021BF');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634727ACA70');
        $this->addSql('ALTER TABLE commantaire DROP FOREIGN KEY FK_93BF4CAF23A0E66');
        $this->addSql('ALTER TABLE commantaire DROP FOREIGN KEY FK_93BF4CAF727ACA70');
        $this->addSql('ALTER TABLE condidature DROP FOREIGN KEY FK_FDF2E30BC1003072');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5404021BF');
        $this->addSql('ALTER TABLE element_devis DROP FOREIGN KEY FK_4F05B1B24AE6EA2F');
        $this->addSql('ALTER TABLE element_devis DROP FOREIGN KEY FK_4F05B1B28A44833F');
        $this->addSql('ALTER TABLE element_menu DROP FOREIGN KEY FK_3E3B1B6ADD3795AD');
        $this->addSql('ALTER TABLE element_menu DROP FOREIGN KEY FK_3E3B1B6AB438191E');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E404021BF');
        $this->addSql('ALTER TABLE formation ADD user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF8D93D649 FOREIGN KEY (user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_404021BF8D93D649 ON formation (user)');
        $this->addSql('ALTER TABLE formation_page DROP FOREIGN KEY FK_43D55360B438191E');
        $this->addSql('ALTER TABLE formation_page DROP FOREIGN KEY FK_43D55360C2B1A31C');
    }
}
