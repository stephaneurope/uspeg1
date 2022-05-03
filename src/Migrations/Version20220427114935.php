<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427114935 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE essayage ADD adherent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE essayage ADD CONSTRAINT FK_410BBC2425F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_410BBC2425F06C53 ON essayage (adherent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE essayage DROP FOREIGN KEY FK_410BBC2425F06C53');
        $this->addSql('DROP INDEX UNIQ_410BBC2425F06C53 ON essayage');
        $this->addSql('ALTER TABLE essayage DROP adherent_id');
    }
}
