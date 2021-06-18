<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524125714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE import_csv ADD sub_category VARCHAR(255) DEFAULT NULL, ADD sex VARCHAR(255) DEFAULT NULL, ADD complement VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD postal_code VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD record DATE DEFAULT NULL, ADD home_phone VARCHAR(255) DEFAULT NULL, ADD mobile_phone VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD place_of_birth VARCHAR(255) DEFAULT NULL, ADD club_change VARCHAR(255) DEFAULT NULL, ADD club_out VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE import_csv DROP sub_category, DROP sex, DROP complement, DROP address, DROP postal_code, DROP city, DROP record, DROP home_phone, DROP mobile_phone, DROP email, DROP place_of_birth, DROP club_change, DROP club_out');
    }
}
