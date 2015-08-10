<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150803155927 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE currency_rate (id INT AUTO_INCREMENT NOT NULL, currency_from VARCHAR(12) NOT NULL, currency_to VARCHAR(12) NOT NULL, exchange_rate NUMERIC(15, 4) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_client_group (page_id INT NOT NULL, client_group_id INT NOT NULL, INDEX IDX_70B1743CC4663E4 (page_id), INDEX IDX_70B1743CD0B2E982 (client_group_id), PRIMARY KEY(page_id, client_group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping_method (id INT AUTO_INCREMENT NOT NULL, tax_id INT DEFAULT NULL, calculator VARCHAR(64) DEFAULT NULL, currency VARCHAR(16) NOT NULL, enabled TINYINT(1) NOT NULL, hierarchy INT DEFAULT 0, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, deletedBy VARCHAR(255) DEFAULT NULL, INDEX IDX_7503FF2FB2A824D8 (tax_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping_method_cost (id INT AUTO_INCREMENT NOT NULL, shipping_method_id INT NOT NULL, range_from NUMERIC(15, 4) NOT NULL, range_to NUMERIC(15, 4) NOT NULL, cost NUMERIC(15, 4) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_889969295F7D6850 (shipping_method_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping_method_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_CB491D2B2C2AC5D3 (translatable_id), UNIQUE INDEX shipping_method_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, payment_method_id INT DEFAULT NULL, order_status_id INT NOT NULL, shipping_method_id INT DEFAULT NULL, shop_id INT NOT NULL, session_id VARCHAR(255) NOT NULL, currency VARCHAR(16) NOT NULL, comment VARCHAR(1000) NOT NULL, billing_address_first_name VARCHAR(255) DEFAULT NULL, billing_address_last_name VARCHAR(255) DEFAULT NULL, billing_address_street VARCHAR(255) DEFAULT NULL, billing_address_street_no VARCHAR(255) DEFAULT NULL, billing_address_flat_no VARCHAR(255) DEFAULT NULL, billing_address_post_code VARCHAR(255) DEFAULT NULL, billing_address_province VARCHAR(255) DEFAULT NULL, billing_address_city VARCHAR(255) DEFAULT NULL, billing_address_country VARCHAR(3) DEFAULT NULL, shipping_address_first_name VARCHAR(255) DEFAULT NULL, shipping_address_last_name VARCHAR(255) DEFAULT NULL, shipping_address_street VARCHAR(255) DEFAULT NULL, shipping_address_street_no VARCHAR(255) DEFAULT NULL, shipping_address_flat_no VARCHAR(255) DEFAULT NULL, shipping_address_post_code VARCHAR(255) DEFAULT NULL, shipping_address_province VARCHAR(255) DEFAULT NULL, shipping_address_city VARCHAR(255) DEFAULT NULL, shipping_address_country VARCHAR(3) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_E52FFDEE19EB6921 (client_id), INDEX IDX_E52FFDEE5AA1164F (payment_method_id), INDEX IDX_E52FFDEED7707B45 (order_status_id), INDEX IDX_E52FFDEE5F7D6850 (shipping_method_id), INDEX IDX_E52FFDEE4D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders_modifier (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, net_value NUMERIC(15, 4) NOT NULL, tax_value NUMERIC(15, 4) NOT NULL, gross_value NUMERIC(15, 4) NOT NULL, is_increase TINYINT(1) NOT NULL, hierarchy INT DEFAULT 0, modifier_detalils_name VARCHAR(255) NOT NULL, modifier_detalils_description VARCHAR(255) NOT NULL, INDEX IDX_6C99043B8D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders_product (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, product_id INT NOT NULL, attribute_id INT DEFAULT NULL, quantity NUMERIC(15, 4) NOT NULL, tax_value NUMERIC(15, 4) NOT NULL, weight NUMERIC(15, 4) NOT NULL, net_price_amount NUMERIC(15, 4) NOT NULL, net_price_currency VARCHAR(16) NOT NULL, gross_price_amount NUMERIC(15, 4) NOT NULL, gross_price_currency VARCHAR(16) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_223F76D68D9F6D38 (order_id), INDEX IDX_223F76D64584665A (product_id), INDEX IDX_223F76D6B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_client_group ADD CONSTRAINT FK_70B1743CC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_client_group ADD CONSTRAINT FK_70B1743CD0B2E982 FOREIGN KEY (client_group_id) REFERENCES client_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shipping_method ADD CONSTRAINT FK_7503FF2FB2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE shipping_method_cost ADD CONSTRAINT FK_889969295F7D6850 FOREIGN KEY (shipping_method_id) REFERENCES shipping_method (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shipping_method_translation ADD CONSTRAINT FK_CB491D2B2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES shipping_method (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE5AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEED7707B45 FOREIGN KEY (order_status_id) REFERENCES order_status (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE5F7D6850 FOREIGN KEY (shipping_method_id) REFERENCES shipping_method (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE4D16C4DD FOREIGN KEY (shop_id) REFERENCES Shop (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE orders_modifier ADD CONSTRAINT FK_6C99043B8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders_product ADD CONSTRAINT FK_223F76D68D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders_product ADD CONSTRAINT FK_223F76D64584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE orders_product ADD CONSTRAINT FK_223F76D6B6E62EFA FOREIGN KEY (attribute_id) REFERENCES product_attribute (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE Locale ADD currency_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Locale ADD CONSTRAINT FK_462CC3AE38248176 FOREIGN KEY (currency_id) REFERENCES currency (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_462CC3AE38248176 ON Locale (currency_id)');
        $this->addSql('ALTER TABLE Shop ADD default_order_status_id INT DEFAULT NULL, ADD default_country VARCHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE Shop ADD CONSTRAINT FK_C58E39C4F26D399 FOREIGN KEY (default_order_status_id) REFERENCES order_status (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C58E39C4F26D399 ON Shop (default_order_status_id)');
        $this->addSql('ALTER TABLE client ADD conditions_accepted TINYINT(1) NOT NULL, ADD newsletter_accepted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE client_address ADD address_first_name VARCHAR(255) DEFAULT NULL, ADD address_last_name VARCHAR(255) DEFAULT NULL, ADD address_street VARCHAR(255) DEFAULT NULL, ADD address_street_no VARCHAR(255) DEFAULT NULL, ADD address_flat_no VARCHAR(255) DEFAULT NULL, ADD address_post_code VARCHAR(255) DEFAULT NULL, ADD address_province VARCHAR(255) DEFAULT NULL, ADD address_city VARCHAR(255) DEFAULT NULL, DROP street, DROP street_no, DROP flat_no, DROP post_code, DROP province, DROP city, CHANGE country address_country VARCHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E97E9E4C8C');
        $this->addSql('DROP INDEX IDX_1483A5E97E9E4C8C ON users');
        $this->addSql('ALTER TABLE users DROP photo_id');
        $this->addSql('ALTER TABLE product ADD buy_tax_id INT DEFAULT NULL, ADD sell_tax_id INT DEFAULT NULL, ADD sell_price_discounted_amount NUMERIC(15, 4) DEFAULT NULL, ADD sell_price_valid_from DATETIME DEFAULT NULL, ADD sell_price_valid_to DATETIME DEFAULT NULL, DROP buy_price_tax, DROP sell_price_tax, CHANGE buy_price_currency buy_price_currency VARCHAR(16) NOT NULL, CHANGE sell_price_currency sell_price_currency VARCHAR(16) NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADE944AC3F FOREIGN KEY (buy_tax_id) REFERENCES tax (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADD06D914B FOREIGN KEY (sell_tax_id) REFERENCES tax (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_D34A04ADE944AC3F ON product (buy_tax_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADD06D914B ON product (sell_tax_id)');
        $this->addSql('ALTER TABLE cart ADD client_id INT DEFAULT NULL, ADD payment_method_id INT DEFAULT NULL, ADD shipping_method_id INT DEFAULT NULL, ADD shop_id INT NOT NULL, ADD session_id VARCHAR(255) NOT NULL, ADD total_quantity NUMERIC(15, 4) NOT NULL, ADD total_weight NUMERIC(15, 4) NOT NULL, ADD total_net_price NUMERIC(15, 4) NOT NULL, ADD total_gross_price NUMERIC(15, 4) NOT NULL, ADD total_tax_amount NUMERIC(15, 4) NOT NULL, ADD billing_address_first_name VARCHAR(255) DEFAULT NULL, ADD billing_address_last_name VARCHAR(255) DEFAULT NULL, ADD billing_address_street VARCHAR(255) DEFAULT NULL, ADD billing_address_street_no VARCHAR(255) DEFAULT NULL, ADD billing_address_flat_no VARCHAR(255) DEFAULT NULL, ADD billing_address_post_code VARCHAR(255) DEFAULT NULL, ADD billing_address_province VARCHAR(255) DEFAULT NULL, ADD billing_address_city VARCHAR(255) DEFAULT NULL, ADD billing_address_country VARCHAR(3) DEFAULT NULL, ADD shipping_address_first_name VARCHAR(255) DEFAULT NULL, ADD shipping_address_last_name VARCHAR(255) DEFAULT NULL, ADD shipping_address_street VARCHAR(255) DEFAULT NULL, ADD shipping_address_street_no VARCHAR(255) DEFAULT NULL, ADD shipping_address_flat_no VARCHAR(255) DEFAULT NULL, ADD shipping_address_post_code VARCHAR(255) DEFAULT NULL, ADD shipping_address_province VARCHAR(255) DEFAULT NULL, ADD shipping_address_city VARCHAR(255) DEFAULT NULL, ADD shipping_address_country VARCHAR(3) DEFAULT NULL, ADD contact_details_phone VARCHAR(255) DEFAULT NULL, ADD contact_details_secondary_phone VARCHAR(255) DEFAULT NULL, ADD contact_details_email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B719EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B75AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B75F7D6850 FOREIGN KEY (shipping_method_id) REFERENCES shipping_method (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B74D16C4DD FOREIGN KEY (shop_id) REFERENCES Shop (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B719EB6921 ON cart (client_id)');
        $this->addSql('CREATE INDEX IDX_BA388B75AA1164F ON cart (payment_method_id)');
        $this->addSql('CREATE INDEX IDX_BA388B75F7D6850 ON cart (shipping_method_id)');
        $this->addSql('CREATE INDEX IDX_BA388B74D16C4DD ON cart (shop_id)');
        $this->addSql('ALTER TABLE cart_product DROP INDEX UNIQ_2890CCAA4584665A, ADD INDEX IDX_2890CCAA4584665A (product_id)');
        $this->addSql('ALTER TABLE cart_product ADD attribute_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAAB6E62EFA FOREIGN KEY (attribute_id) REFERENCES product_attribute (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_2890CCAAB6E62EFA ON cart_product (attribute_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shipping_method_cost DROP FOREIGN KEY FK_889969295F7D6850');
        $this->addSql('ALTER TABLE shipping_method_translation DROP FOREIGN KEY FK_CB491D2B2C2AC5D3');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE5F7D6850');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B75F7D6850');
        $this->addSql('ALTER TABLE orders_modifier DROP FOREIGN KEY FK_6C99043B8D9F6D38');
        $this->addSql('ALTER TABLE orders_product DROP FOREIGN KEY FK_223F76D68D9F6D38');
        $this->addSql('DROP TABLE currency_rate');
        $this->addSql('DROP TABLE page_client_group');
        $this->addSql('DROP TABLE shipping_method');
        $this->addSql('DROP TABLE shipping_method_cost');
        $this->addSql('DROP TABLE shipping_method_translation');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE orders_modifier');
        $this->addSql('DROP TABLE orders_product');
        $this->addSql('ALTER TABLE Locale DROP FOREIGN KEY FK_462CC3AE38248176');
        $this->addSql('DROP INDEX IDX_462CC3AE38248176 ON Locale');
        $this->addSql('ALTER TABLE Locale DROP currency_id');
        $this->addSql('ALTER TABLE Shop DROP FOREIGN KEY FK_C58E39C4F26D399');
        $this->addSql('DROP INDEX IDX_C58E39C4F26D399 ON Shop');
        $this->addSql('ALTER TABLE Shop DROP default_order_status_id, DROP default_country');
        $this->addSql('DROP INDEX UNIQ_BA388B719EB6921 ON cart');
        $this->addSql('DROP INDEX IDX_BA388B75AA1164F ON cart');
        $this->addSql('DROP INDEX IDX_BA388B75F7D6850 ON cart');
        $this->addSql('DROP INDEX IDX_BA388B74D16C4DD ON cart');
        $this->addSql('ALTER TABLE cart DROP client_id, DROP payment_method_id, DROP shipping_method_id, DROP shop_id, DROP session_id, DROP total_quantity, DROP total_weight, DROP total_net_price, DROP total_gross_price, DROP total_tax_amount, DROP billing_address_first_name, DROP billing_address_last_name, DROP billing_address_street, DROP billing_address_street_no, DROP billing_address_flat_no, DROP billing_address_post_code, DROP billing_address_province, DROP billing_address_city, DROP billing_address_country, DROP shipping_address_first_name, DROP shipping_address_last_name, DROP shipping_address_street, DROP shipping_address_street_no, DROP shipping_address_flat_no, DROP shipping_address_post_code, DROP shipping_address_province, DROP shipping_address_city, DROP shipping_address_country, DROP contact_details_phone, DROP contact_details_secondary_phone, DROP contact_details_email');
        $this->addSql('ALTER TABLE cart_product DROP INDEX IDX_2890CCAA4584665A, ADD UNIQUE INDEX UNIQ_2890CCAA4584665A (product_id)');
        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAAB6E62EFA');
        $this->addSql('DROP INDEX IDX_2890CCAAB6E62EFA ON cart_product');
        $this->addSql('ALTER TABLE cart_product DROP attribute_id');
        $this->addSql('ALTER TABLE client DROP conditions_accepted, DROP newsletter_accepted');
        $this->addSql('ALTER TABLE client_address ADD street VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD street_no VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD flat_no VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD post_code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD province VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD city VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP address_first_name, DROP address_last_name, DROP address_street, DROP address_street_no, DROP address_flat_no, DROP address_post_code, DROP address_province, DROP address_city, CHANGE address_country country VARCHAR(3) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADE944AC3F');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADD06D914B');
        $this->addSql('DROP INDEX IDX_D34A04ADE944AC3F ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADD06D914B ON product');
        $this->addSql('ALTER TABLE product ADD buy_price_tax INT NOT NULL, ADD sell_price_tax INT NOT NULL, DROP buy_tax_id, DROP sell_tax_id, DROP sell_price_discounted_amount, DROP sell_price_valid_from, DROP sell_price_valid_to, CHANGE buy_price_currency buy_price_currency INT NOT NULL, CHANGE sell_price_currency sell_price_currency INT NOT NULL');
        $this->addSql('ALTER TABLE users ADD photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E97E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_1483A5E97E9E4C8C ON users (photo_id)');
    }
}
