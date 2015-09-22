<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150921233705 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD buy_price_net_amount NUMERIC(15, 4) NOT NULL, ADD buy_price_gross_amount NUMERIC(15, 4) NOT NULL, ADD buy_price_tax_amount NUMERIC(15, 4) NOT NULL, ADD buy_price_tax_rate NUMERIC(15, 4) NOT NULL, ADD sell_price_net_amount NUMERIC(15, 4) NOT NULL, ADD sell_price_gross_amount NUMERIC(15, 4) NOT NULL, ADD sell_price_tax_amount NUMERIC(15, 4) NOT NULL, ADD sell_price_tax_rate NUMERIC(15, 4) NOT NULL, DROP buy_price_amount, DROP sell_price_amount');
        $this->addSql('ALTER TABLE orders_product ADD net_price_net_amount NUMERIC(15, 4) NOT NULL, ADD net_price_gross_amount NUMERIC(15, 4) NOT NULL, ADD net_price_tax_amount NUMERIC(15, 4) NOT NULL, ADD net_price_tax_rate NUMERIC(15, 4) NOT NULL, ADD gross_price_net_amount NUMERIC(15, 4) NOT NULL, ADD gross_price_gross_amount NUMERIC(15, 4) NOT NULL, ADD gross_price_tax_amount NUMERIC(15, 4) NOT NULL, ADD gross_price_tax_rate NUMERIC(15, 4) NOT NULL, DROP net_price_amount, DROP gross_price_amount');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders_product ADD net_price_amount NUMERIC(15, 4) NOT NULL, ADD gross_price_amount NUMERIC(15, 4) NOT NULL, DROP net_price_net_amount, DROP net_price_gross_amount, DROP net_price_tax_amount, DROP net_price_tax_rate, DROP gross_price_net_amount, DROP gross_price_gross_amount, DROP gross_price_tax_amount, DROP gross_price_tax_rate');
        $this->addSql('ALTER TABLE product ADD buy_price_amount NUMERIC(15, 4) NOT NULL, ADD sell_price_amount NUMERIC(15, 4) NOT NULL, DROP buy_price_net_amount, DROP buy_price_gross_amount, DROP buy_price_tax_amount, DROP buy_price_tax_rate, DROP sell_price_net_amount, DROP sell_price_gross_amount, DROP sell_price_tax_amount, DROP sell_price_tax_rate');
    }
}
