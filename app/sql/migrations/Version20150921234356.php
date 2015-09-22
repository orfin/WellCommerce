<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150921234356 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD sell_price_discounted_gross_amount NUMERIC(15, 4) DEFAULT NULL, ADD sell_price_discounted_tax_amount NUMERIC(15, 4) DEFAULT NULL, ADD sell_price_discounted_tax_rate NUMERIC(15, 4) DEFAULT NULL, CHANGE sell_price_discounted_amount sell_price_discounted_net_amount NUMERIC(15, 4) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD sell_price_discounted_amount NUMERIC(15, 4) DEFAULT NULL, DROP sell_price_discounted_net_amount, DROP sell_price_discounted_gross_amount, DROP sell_price_discounted_tax_amount, DROP sell_price_discounted_tax_rate');
    }
}
