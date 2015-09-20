<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150920151448 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_translation CHANGE business_hours business_hours LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE news CHANGE publish publish TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE featured featured TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE Company DROP FOREIGN KEY FK_800230D37E9E4C8C');
        $this->addSql('ALTER TABLE Company CHANGE short_name short_name VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX idx_800230d37e9e4c8c ON Company');
        $this->addSql('CREATE INDEX IDX_4FBF094F7E9E4C8C ON Company (photo_id)');
        $this->addSql('ALTER TABLE Company ADD CONSTRAINT FK_800230D37E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE Shop DROP FOREIGN KEY FK_C58E39C4F26D399');
        $this->addSql('ALTER TABLE Shop DROP FOREIGN KEY FK_C58E39C59027487');
        $this->addSql('ALTER TABLE Shop DROP FOREIGN KEY FK_C58E39C979B1AD6');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC6A4CA2F47645AE ON Shop (url)');
        $this->addSql('DROP INDEX idx_c58e39c979b1ad6 ON Shop');
        $this->addSql('CREATE INDEX IDX_AC6A4CA2979B1AD6 ON Shop (company_id)');
        $this->addSql('DROP INDEX idx_c58e39c59027487 ON Shop');
        $this->addSql('CREATE INDEX IDX_AC6A4CA259027487 ON Shop (theme_id)');
        $this->addSql('DROP INDEX idx_c58e39c4f26d399 ON Shop');
        $this->addSql('CREATE INDEX IDX_AC6A4CA24F26D399 ON Shop (default_order_status_id)');
        $this->addSql('ALTER TABLE Shop ADD CONSTRAINT FK_C58E39C4F26D399 FOREIGN KEY (default_order_status_id) REFERENCES order_status (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE Shop ADD CONSTRAINT FK_C58E39C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE Shop ADD CONSTRAINT FK_C58E39C979B1AD6 FOREIGN KEY (company_id) REFERENCES Company (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product_attribute CHANGE hierarchy hierarchy INT DEFAULT 0 NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9E93FB79772E836A ON layout_box (identifier)');
        $this->addSql('ALTER TABLE orders_product DROP FOREIGN KEY FK_223F76D6B6E62EFA');
        $this->addSql('DROP INDEX IDX_223F76D6B6E62EFA ON orders_product');
        $this->addSql('ALTER TABLE orders_product CHANGE attribute_id product_attribute_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders_product ADD CONSTRAINT FK_223F76D63B420C91 FOREIGN KEY (product_attribute_id) REFERENCES product_attribute (id) ON DELETE RESTRICT');
        $this->addSql('CREATE INDEX IDX_223F76D63B420C91 ON orders_product (product_attribute_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C1EDBA85E237E06 ON order_status_translation (name)');
        $this->addSql('ALTER TABLE cart ADD total_quantity NUMERIC(15, 4) NOT NULL, ADD total_weight NUMERIC(15, 4) NOT NULL, ADD total_net_price NUMERIC(15, 4) NOT NULL, ADD total_gross_price NUMERIC(15, 4) NOT NULL, ADD total_tax_amount NUMERIC(15, 4) NOT NULL, DROP totals_quantity, DROP totals_weight, DROP totals_net_price, DROP totals_gross_price, DROP totals_tax_amount');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F7E9E4C8C');
        $this->addSql('ALTER TABLE company CHANGE short_name short_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX idx_4fbf094f7e9e4c8c ON company');
        $this->addSql('CREATE INDEX IDX_800230D37E9E4C8C ON company (photo_id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F7E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL');
        $this->addSql('DROP INDEX UNIQ_AC6A4CA2F47645AE ON shop');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2979B1AD6');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA259027487');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA24F26D399');
        $this->addSql('DROP INDEX idx_ac6a4ca2979b1ad6 ON shop');
        $this->addSql('CREATE INDEX IDX_C58E39C979B1AD6 ON shop (company_id)');
        $this->addSql('DROP INDEX idx_ac6a4ca259027487 ON shop');
        $this->addSql('CREATE INDEX IDX_C58E39C59027487 ON shop (theme_id)');
        $this->addSql('DROP INDEX idx_ac6a4ca24f26d399 ON shop');
        $this->addSql('CREATE INDEX IDX_C58E39C4F26D399 ON shop (default_order_status_id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA259027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA24F26D399 FOREIGN KEY (default_order_status_id) REFERENCES order_status (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cart ADD totals_quantity NUMERIC(15, 4) NOT NULL, ADD totals_weight NUMERIC(15, 4) NOT NULL, ADD totals_net_price NUMERIC(15, 4) NOT NULL, ADD totals_gross_price NUMERIC(15, 4) NOT NULL, ADD totals_tax_amount NUMERIC(15, 4) NOT NULL, DROP total_quantity, DROP total_weight, DROP total_net_price, DROP total_gross_price, DROP total_tax_amount');
        $this->addSql('ALTER TABLE contact_translation CHANGE business_hours business_hours LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX UNIQ_9E93FB79772E836A ON layout_box');
        $this->addSql('ALTER TABLE news CHANGE publish publish TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE featured featured TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_4C1EDBA85E237E06 ON order_status_translation');
        $this->addSql('ALTER TABLE orders_product DROP FOREIGN KEY FK_223F76D63B420C91');
        $this->addSql('DROP INDEX IDX_223F76D63B420C91 ON orders_product');
        $this->addSql('ALTER TABLE orders_product CHANGE product_attribute_id attribute_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders_product ADD CONSTRAINT FK_223F76D6B6E62EFA FOREIGN KEY (attribute_id) REFERENCES product_attribute (id)');
        $this->addSql('CREATE INDEX IDX_223F76D6B6E62EFA ON orders_product (attribute_id)');
        $this->addSql('ALTER TABLE product_attribute CHANGE hierarchy hierarchy INT DEFAULT 0');
    }
}
