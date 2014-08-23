<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140823113039 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE product_photo (id INT AUTO_INCREMENT NOT NULL, photo_id INT DEFAULT NULL, product_id INT DEFAULT NULL, main_photo TINYINT(1) DEFAULT '0' NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, hierarchy INT DEFAULT 0 NOT NULL, INDEX IDX_B5EBFF447E9E4C8C (photo_id), INDEX IDX_B5EBFF444584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE product_photo ADD CONSTRAINT FK_B5EBFF447E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE product_photo ADD CONSTRAINT FK_B5EBFF444584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE product ADD hierarchy INT DEFAULT 0 NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE product_photo");
        $this->addSql("ALTER TABLE product DROP hierarchy");
    }
}
