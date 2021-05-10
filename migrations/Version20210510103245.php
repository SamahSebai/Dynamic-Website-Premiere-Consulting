<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210510103245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commantaire DROP FOREIGN KEY FK_93BF4CAF8D93D649');
        $this->addSql('DROP INDEX IDX_93BF4CAF8D93D649 ON commantaire');
        $this->addSql('ALTER TABLE commantaire DROP user');
        $this->addSql('ALTER TABLE condidature DROP FOREIGN KEY FK_FDF2E30B2DA17977');
        $this->addSql('DROP INDEX IDX_FDF2E30B2DA17977 ON condidature');
        $this->addSql('ALTER TABLE condidature DROP User');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6388D93D649');
        $this->addSql('DROP INDEX IDX_4C62E6388D93D649 ON contact');
        $this->addSql('ALTER TABLE contact DROP user');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E8D93D649');
        $this->addSql('DROP INDEX IDX_B26681E8D93D649 ON evenement');
        $this->addSql('ALTER TABLE evenement DROP user');
        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C88D93D649');
        $this->addSql('DROP INDEX IDX_7E8585C88D93D649 ON newsletter');
        $this->addSql('ALTER TABLE newsletter DROP user');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B468D93D649');
        $this->addSql('DROP INDEX IDX_B4271B468D93D649 ON recherche');
        $this->addSql('ALTER TABLE recherche DROP user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commantaire ADD user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commantaire ADD CONSTRAINT FK_93BF4CAF8D93D649 FOREIGN KEY (user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_93BF4CAF8D93D649 ON commantaire (user)');
        $this->addSql('ALTER TABLE condidature ADD User INT DEFAULT NULL');
        $this->addSql('ALTER TABLE condidature ADD CONSTRAINT FK_FDF2E30B2DA17977 FOREIGN KEY (User) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_FDF2E30B2DA17977 ON condidature (User)');
        $this->addSql('ALTER TABLE contact ADD user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6388D93D649 FOREIGN KEY (user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_4C62E6388D93D649 ON contact (user)');
        $this->addSql('ALTER TABLE evenement ADD user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E8D93D649 FOREIGN KEY (user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_B26681E8D93D649 ON evenement (user)');
        $this->addSql('ALTER TABLE newsletter ADD user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C88D93D649 FOREIGN KEY (user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_7E8585C88D93D649 ON newsletter (user)');
        $this->addSql('ALTER TABLE recherche ADD user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B468D93D649 FOREIGN KEY (user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_B4271B468D93D649 ON recherche (user)');
    }
}
