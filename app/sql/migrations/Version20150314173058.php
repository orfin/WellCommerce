<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150314173058 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shop_category DROP FOREIGN KEY FK_DDF4E3574584665A');
        $this->addSql('DROP INDEX IDX_DDF4E3574584665A ON shop_category');
        $this->addSql('ALTER TABLE shop_category DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE shop_category CHANGE product_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE shop_category ADD CONSTRAINT FK_DDF4E35712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_DDF4E35712469DE2 ON shop_category (category_id)');
        $this->addSql('ALTER TABLE shop_category ADD PRIMARY KEY (category_id, shop_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shop_category DROP FOREIGN KEY FK_DDF4E35712469DE2');
        $this->addSql('DROP INDEX IDX_DDF4E35712469DE2 ON shop_category');
        $this->addSql('ALTER TABLE shop_category DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE shop_category CHANGE category_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE shop_category ADD CONSTRAINT FK_DDF4E3574584665A FOREIGN KEY (product_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_DDF4E3574584665A ON shop_category (product_id)');
        $this->addSql('ALTER TABLE shop_category ADD PRIMARY KEY (product_id, shop_id)');
    }
}
