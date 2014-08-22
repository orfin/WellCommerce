<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140822204100 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, producer_id INT DEFAULT NULL, tax_id INT DEFAULT NULL, unit_id INT DEFAULT NULL, availability_id INT DEFAULT NULL, photo_id INT DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_D34A04AD89B658FE (producer_id), INDEX IDX_D34A04ADB2A824D8 (tax_id), INDEX IDX_D34A04ADF8BD700D (unit_id), INDEX IDX_D34A04AD61778466 (availability_id), INDEX IDX_D34A04AD7E9E4C8C (photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE shop_product (product_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_D07944874584665A (product_id), INDEX IDX_D07944874D16C4DD (shop_id), PRIMARY KEY(product_id, shop_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE category_product (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_149244D34584665A (product_id), INDEX IDX_149244D312469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE product_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, short_description LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, INDEX IDX_1846DB702C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_1846DB702C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE product ADD CONSTRAINT FK_D34A04AD89B658FE FOREIGN KEY (producer_id) REFERENCES producer (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE product ADD CONSTRAINT FK_D34A04ADB2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE product ADD CONSTRAINT FK_D34A04AD61778466 FOREIGN KEY (availability_id) REFERENCES availability (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE shop_product ADD CONSTRAINT FK_D07944874584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE shop_product ADD CONSTRAINT FK_D07944874D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE category_product ADD CONSTRAINT FK_149244D34584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE category_product ADD CONSTRAINT FK_149244D312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE product_translation ADD CONSTRAINT FK_1846DB702C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES product (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE shop_product DROP FOREIGN KEY FK_D07944874584665A");
        $this->addSql("ALTER TABLE category_product DROP FOREIGN KEY FK_149244D34584665A");
        $this->addSql("ALTER TABLE product_translation DROP FOREIGN KEY FK_1846DB702C2AC5D3");
        $this->addSql("DROP TABLE product");
        $this->addSql("DROP TABLE shop_product");
        $this->addSql("DROP TABLE category_product");
        $this->addSql("DROP TABLE product_translation");
    }
}
