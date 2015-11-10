<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151110102605 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE5F7D6850');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE5F7D6850 FOREIGN KEY (shipping_method_id) REFERENCES shipping_method (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE orders_product DROP sell_price_discounted_net_amount, DROP sell_price_discounted_gross_amount, DROP sell_price_discounted_tax_amount, DROP sell_price_valid_from, DROP sell_price_valid_to');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE5F7D6850');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE5F7D6850 FOREIGN KEY (shipping_method_id) REFERENCES shipping_method (id)');
        $this->addSql('ALTER TABLE orders_product ADD sell_price_discounted_net_amount NUMERIC(15, 2) DEFAULT NULL, ADD sell_price_discounted_gross_amount NUMERIC(15, 2) DEFAULT NULL, ADD sell_price_discounted_tax_amount NUMERIC(15, 2) DEFAULT NULL, ADD sell_price_valid_from DATETIME DEFAULT NULL, ADD sell_price_valid_to DATETIME DEFAULT NULL');
    }
}
