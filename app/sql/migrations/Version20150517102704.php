<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150517102704 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_product ADD attribute_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAAB6E62EFA FOREIGN KEY (attribute_id) REFERENCES product_attribute (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2890CCAAB6E62EFA ON cart_product (attribute_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAAB6E62EFA');
        $this->addSql('DROP INDEX UNIQ_2890CCAAB6E62EFA ON cart_product');
        $this->addSql('ALTER TABLE cart_product DROP attribute_id');
    }
}
