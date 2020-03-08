<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200227131346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adherent (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, born DATETIME DEFAULT NULL, sub_category VARCHAR(255) DEFAULT NULL, to_number INT DEFAULT NULL, sex VARCHAR(255) DEFAULT NULL, complement VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, lieut VARCHAR(255) DEFAULT NULL, postal_code INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, record DATETIME DEFAULT NULL, licence_type VARCHAR(255) DEFAULT NULL, home_phone VARCHAR(255) DEFAULT NULL, mobile_phone VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, category_arbitre VARCHAR(255) DEFAULT NULL, place_of_birth VARCHAR(255) DEFAULT NULL, club_change VARCHAR(255) DEFAULT NULL, club_out VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE adherent');
    }
}
