<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150607230852 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_address ADD address_first_name VARCHAR(255) DEFAULT NULL, ADD address_last_name VARCHAR(255) DEFAULT NULL, ADD address_street VARCHAR(255) DEFAULT NULL, ADD address_street_no VARCHAR(255) DEFAULT NULL, ADD address_flat_no VARCHAR(255) DEFAULT NULL, ADD address_post_code VARCHAR(255) DEFAULT NULL, ADD address_province VARCHAR(255) DEFAULT NULL, ADD address_city VARCHAR(255) DEFAULT NULL, DROP street, DROP street_no, DROP flat_no, DROP post_code, DROP province, DROP city, CHANGE country address_country VARCHAR(3) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_address ADD street VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD street_no VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD flat_no VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD post_code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD province VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD city VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP address_first_name, DROP address_last_name, DROP address_street, DROP address_street_no, DROP address_flat_no, DROP address_post_code, DROP address_province, DROP address_city, CHANGE address_country country VARCHAR(3) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
