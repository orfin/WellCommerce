<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150607212017 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart ADD total_net_price NUMERIC(15, 4) NOT NULL, ADD total_gross_price NUMERIC(15, 4) NOT NULL, ADD total_tax_amount NUMERIC(15, 4) NOT NULL, DROP total_price_net, DROP total_price_gross');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart ADD total_price_net NUMERIC(15, 4) NOT NULL, ADD total_price_gross NUMERIC(15, 4) NOT NULL, DROP total_net_price, DROP total_gross_price, DROP total_tax_amount');
    }
}
