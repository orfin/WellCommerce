<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150517233533 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_product DROP INDEX UNIQ_2890CCAA4584665A, ADD INDEX IDX_2890CCAA4584665A (product_id)');
        $this->addSql('ALTER TABLE cart_product DROP INDEX UNIQ_2890CCAAB6E62EFA, ADD INDEX IDX_2890CCAAB6E62EFA (attribute_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_product DROP INDEX IDX_2890CCAA4584665A, ADD UNIQUE INDEX UNIQ_2890CCAA4584665A (product_id)');
        $this->addSql('ALTER TABLE cart_product DROP INDEX IDX_2890CCAAB6E62EFA, ADD UNIQUE INDEX UNIQ_2890CCAAB6E62EFA (attribute_id)');
    }
}
