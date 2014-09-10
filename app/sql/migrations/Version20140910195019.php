<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140910195019 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE shop_payment_method (payment_method_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_EBC0A0F05AA1164F (payment_method_id), INDEX IDX_EBC0A0F04D16C4DD (shop_id), PRIMARY KEY(payment_method_id, shop_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop_payment_method ADD CONSTRAINT FK_EBC0A0F05AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_payment_method ADD CONSTRAINT FK_EBC0A0F04D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE shop_payment_method');
    }
}
