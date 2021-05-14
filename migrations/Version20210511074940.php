<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511074940 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE temoingage (id INT AUTO_INCREMENT NOT NULL, auteur VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6388D93D649 FOREIGN KEY (user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_4C62E6388D93D649 ON contact (user)');
        $this->addSql('ALTER TABLE recherche ADD user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B468D93D649 FOREIGN KEY (user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_B4271B468D93D649 ON recherche (user)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE temoingage');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6388D93D649');
        $this->addSql('DROP INDEX IDX_4C62E6388D93D649 ON contact');
        $this->addSql('ALTER TABLE contact DROP user');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B468D93D649');
        $this->addSql('DROP INDEX IDX_B4271B468D93D649 ON recherche');
        $this->addSql('ALTER TABLE recherche DROP user');
    }
}
