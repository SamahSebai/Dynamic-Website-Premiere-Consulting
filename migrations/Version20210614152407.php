<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210614152407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE valpub ADD CONSTRAINT FK_1C1EBCAE23A0E66 FOREIGN KEY (article) REFERENCES article (id)');
        $this->addSql('ALTER TABLE valpub ADD CONSTRAINT FK_1C1EBCAE140AB620 FOREIGN KEY (page) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_1C1EBCAE140AB620 ON valpub (page)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE valpub DROP FOREIGN KEY FK_1C1EBCAE23A0E66');
        $this->addSql('ALTER TABLE valpub DROP FOREIGN KEY FK_1C1EBCAE140AB620');
        $this->addSql('DROP INDEX IDX_1C1EBCAE140AB620 ON valpub');
    }
}
