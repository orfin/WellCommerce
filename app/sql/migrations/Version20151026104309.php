<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151026104309 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client_wishlist (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, product_id INT DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_B2071AF419EB6921 (client_id), INDEX IDX_B2071AF44584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group_user (user_id INT NOT NULL, user_group_id INT NOT NULL, INDEX IDX_3AE4BD5A76ED395 (user_id), INDEX IDX_3AE4BD51ED93D47 (user_group_id), PRIMARY KEY(user_id, user_group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, deletedBy VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group_permission (id INT AUTO_INCREMENT NOT NULL, user_group_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, enabled TINYINT(1) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_4A91B1C51ED93D47 (user_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_method_configuration (id INT AUTO_INCREMENT NOT NULL, payment_method_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_3B1AB05F5AA1164F (payment_method_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_wishlist ADD CONSTRAINT FK_B2071AF419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_wishlist ADD CONSTRAINT FK_B2071AF44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE user_group_user ADD CONSTRAINT FK_3AE4BD5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_group_user ADD CONSTRAINT FK_3AE4BD51ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_group_permission ADD CONSTRAINT FK_4A91B1C51ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_group (id)');
        $this->addSql('ALTER TABLE payment_method_configuration ADD CONSTRAINT FK_3B1AB05F5AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE client_address');
        $this->addSql('ALTER TABLE company ADD address_street VARCHAR(255) DEFAULT NULL, ADD address_street_no VARCHAR(255) DEFAULT NULL, ADD address_flat_no VARCHAR(255) DEFAULT NULL, ADD address_post_code VARCHAR(255) DEFAULT NULL, ADD address_province VARCHAR(255) DEFAULT NULL, ADD address_city VARCHAR(255) DEFAULT NULL, DROP street, DROP street_no, DROP flat_no, DROP post_code, DROP province, DROP city, CHANGE country address_country VARCHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD default_currency VARCHAR(16) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_C7440455E7927C74 ON client');
        $this->addSql('ALTER TABLE client ADD billing_address_first_name VARCHAR(255) DEFAULT NULL, ADD billing_address_last_name VARCHAR(255) DEFAULT NULL, ADD billing_address_street VARCHAR(255) DEFAULT NULL, ADD billing_address_street_no VARCHAR(255) DEFAULT NULL, ADD billing_address_flat_no VARCHAR(255) DEFAULT NULL, ADD billing_address_post_code VARCHAR(255) DEFAULT NULL, ADD billing_address_province VARCHAR(255) DEFAULT NULL, ADD billing_address_city VARCHAR(255) DEFAULT NULL, ADD billing_address_country VARCHAR(3) DEFAULT NULL, ADD billing_address_vat_id VARCHAR(255) DEFAULT NULL, ADD billing_address_company_name VARCHAR(255) DEFAULT NULL, ADD shipping_address_first_name VARCHAR(255) DEFAULT NULL, ADD shipping_address_last_name VARCHAR(255) DEFAULT NULL, ADD shipping_address_street VARCHAR(255) DEFAULT NULL, ADD shipping_address_street_no VARCHAR(255) DEFAULT NULL, ADD shipping_address_flat_no VARCHAR(255) DEFAULT NULL, ADD shipping_address_post_code VARCHAR(255) DEFAULT NULL, ADD shipping_address_province VARCHAR(255) DEFAULT NULL, ADD shipping_address_city VARCHAR(255) DEFAULT NULL, ADD shipping_address_country VARCHAR(3) DEFAULT NULL, ADD contact_details_first_name VARCHAR(255) DEFAULT NULL, ADD contact_details_last_name VARCHAR(255) DEFAULT NULL, ADD contact_details_phone VARCHAR(255) DEFAULT NULL, ADD contact_details_secondary_phone VARCHAR(255) DEFAULT NULL, ADD contact_details_email VARCHAR(255) DEFAULT NULL, DROP first_name, DROP last_name, DROP email, DROP phone, CHANGE discount discount NUMERIC(15, 2) NOT NULL');
        $this->addSql('ALTER TABLE orders ADD billing_address_vat_id VARCHAR(255) DEFAULT NULL, ADD billing_address_company_name VARCHAR(255) DEFAULT NULL, ADD contact_details_first_name VARCHAR(255) DEFAULT NULL, ADD contact_details_last_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE orders_product CHANGE quantity quantity INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD billing_address_vat_id VARCHAR(255) DEFAULT NULL, ADD billing_address_company_name VARCHAR(255) DEFAULT NULL, ADD contact_details_first_name VARCHAR(255) DEFAULT NULL, ADD contact_details_last_name VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_group_user DROP FOREIGN KEY FK_3AE4BD51ED93D47');
        $this->addSql('ALTER TABLE user_group_permission DROP FOREIGN KEY FK_4A91B1C51ED93D47');
        $this->addSql('CREATE TABLE client_address (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, address_first_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address_last_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address_street VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address_street_no VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address_flat_no VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address_post_code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address_province VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address_city VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address_country VARCHAR(3) DEFAULT NULL COLLATE utf8_unicode_ci, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, updatedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deletedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_5F732BFC19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_address ADD CONSTRAINT FK_5F732BFC19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('DROP TABLE client_wishlist');
        $this->addSql('DROP TABLE user_group_user');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE user_group_permission');
        $this->addSql('DROP TABLE payment_method_configuration');
        $this->addSql('ALTER TABLE cart DROP billing_address_vat_id, DROP billing_address_company_name, DROP contact_details_first_name, DROP contact_details_last_name');
        $this->addSql('ALTER TABLE client ADD first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD email VARCHAR(60) NOT NULL COLLATE utf8_unicode_ci, ADD phone VARCHAR(60) NOT NULL COLLATE utf8_unicode_ci, DROP billing_address_first_name, DROP billing_address_last_name, DROP billing_address_street, DROP billing_address_street_no, DROP billing_address_flat_no, DROP billing_address_post_code, DROP billing_address_province, DROP billing_address_city, DROP billing_address_country, DROP billing_address_vat_id, DROP billing_address_company_name, DROP shipping_address_first_name, DROP shipping_address_last_name, DROP shipping_address_street, DROP shipping_address_street_no, DROP shipping_address_flat_no, DROP shipping_address_post_code, DROP shipping_address_province, DROP shipping_address_city, DROP shipping_address_country, DROP contact_details_first_name, DROP contact_details_last_name, DROP contact_details_phone, DROP contact_details_secondary_phone, DROP contact_details_email, CHANGE discount discount NUMERIC(15, 4) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('ALTER TABLE company ADD street VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD street_no VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD flat_no VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD post_code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD province VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD city VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP address_street, DROP address_street_no, DROP address_flat_no, DROP address_post_code, DROP address_province, DROP address_city, CHANGE address_country country VARCHAR(3) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE orders DROP billing_address_vat_id, DROP billing_address_company_name, DROP contact_details_first_name, DROP contact_details_last_name');
        $this->addSql('ALTER TABLE orders_product CHANGE quantity quantity NUMERIC(15, 4) NOT NULL');
        $this->addSql('ALTER TABLE shop DROP default_currency');
    }
}
