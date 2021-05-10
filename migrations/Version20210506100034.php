<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506100034 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B8D93D649');
        $this->addSql('DROP INDEX IDX_8B27C52B8D93D649 ON devis');
        $this->addSql('ALTER TABLE devis ADD montant_ttc INT NOT NULL, ADD montant_ht INT NOT NULL, ADD reference VARCHAR(255) NOT NULL, ADD date DATE NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD entreprise VARCHAR(255) NOT NULL, DROP user, DROP code, DROP libeille, DROP montant, DROP service, DROP qualite, DROP prix');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis ADD user INT DEFAULT NULL, ADD code INT NOT NULL, ADD libeille VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD montant INT NOT NULL, ADD service VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD qualite VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD prix DOUBLE PRECISION NOT NULL, DROP montant_ttc, DROP montant_ht, DROP reference, DROP date, DROP nom, DROP prenom, DROP email, DROP entreprise');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B8D93D649 FOREIGN KEY (user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B8D93D649 ON devis (user)');
    }
}
