<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140823124015 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE product_photo DROP FOREIGN KEY FK_B5EBFF444584665A");
        $this->addSql("ALTER TABLE product_photo DROP FOREIGN KEY FK_B5EBFF447E9E4C8C");
        $this->addSql("ALTER TABLE product_photo CHANGE product_id product_id INT NOT NULL, CHANGE photo_id photo_id INT NOT NULL, CHANGE hierarchy hierarchy INT DEFAULT 0");
        $this->addSql("ALTER TABLE product_photo ADD CONSTRAINT FK_B5EBFF444584665A FOREIGN KEY (product_id) REFERENCES product (id)");
        $this->addSql("ALTER TABLE product_photo ADD CONSTRAINT FK_B5EBFF447E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE product_photo DROP FOREIGN KEY FK_B5EBFF447E9E4C8C");
        $this->addSql("ALTER TABLE product_photo DROP FOREIGN KEY FK_B5EBFF444584665A");
        $this->addSql("ALTER TABLE product_photo CHANGE photo_id photo_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL, CHANGE hierarchy hierarchy INT DEFAULT 0 NOT NULL");
        $this->addSql("ALTER TABLE product_photo ADD CONSTRAINT FK_B5EBFF447E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE product_photo ADD CONSTRAINT FK_B5EBFF444584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE SET NULL");
    }
}
