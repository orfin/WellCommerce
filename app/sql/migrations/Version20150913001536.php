<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150913001536 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_address CHANGE address_first_name address_first_name VARCHAR(255) DEFAULT NULL, CHANGE address_last_name address_last_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE orders CHANGE billing_address_first_name billing_address_first_name VARCHAR(255) DEFAULT NULL, CHANGE billing_address_last_name billing_address_last_name VARCHAR(255) DEFAULT NULL, CHANGE shipping_address_first_name shipping_address_first_name VARCHAR(255) DEFAULT NULL, CHANGE shipping_address_last_name shipping_address_last_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart CHANGE billing_address_first_name billing_address_first_name VARCHAR(255) DEFAULT NULL, CHANGE billing_address_last_name billing_address_last_name VARCHAR(255) DEFAULT NULL, CHANGE shipping_address_first_name shipping_address_first_name VARCHAR(255) DEFAULT NULL, CHANGE shipping_address_last_name shipping_address_last_name VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart CHANGE billing_address_first_name billing_address_first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE billing_address_last_name billing_address_last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE shipping_address_first_name shipping_address_first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE shipping_address_last_name shipping_address_last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE client_address CHANGE address_first_name address_first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE address_last_name address_last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE orders CHANGE billing_address_first_name billing_address_first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE billing_address_last_name billing_address_last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE shipping_address_first_name shipping_address_first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE shipping_address_last_name shipping_address_last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
