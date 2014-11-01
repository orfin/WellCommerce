<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141101012841 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE shop_category DROP FOREIGN KEY FK_DDF4E3574D16C4DD');
        $this->addSql('ALTER TABLE shop_currency DROP FOREIGN KEY FK_B2EE72A94D16C4DD');
        $this->addSql('ALTER TABLE shop_locale DROP FOREIGN KEY FK_C422E01A4D16C4DD');
        $this->addSql('ALTER TABLE shop_payment_method DROP FOREIGN KEY FK_EBC0A0F04D16C4DD');
        $this->addSql('ALTER TABLE shop_producer DROP FOREIGN KEY FK_4CDCB34A4D16C4DD');
        $this->addSql('ALTER TABLE shop_product DROP FOREIGN KEY FK_D07944874D16C4DD');
        $this->addSql('ALTER TABLE shop_translation DROP FOREIGN KEY FK_661EB37F2C2AC5D3');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE shop_category');
        $this->addSql('DROP TABLE shop_currency');
        $this->addSql('DROP TABLE shop_locale');
        $this->addSql('DROP TABLE shop_payment_method');
        $this->addSql('DROP TABLE shop_producer');
        $this->addSql('DROP TABLE shop_product');
        $this->addSql('DROP TABLE shop_translation');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, theme_id INT DEFAULT NULL, company_id INT DEFAULT NULL, enabled TINYINT(1) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, updatedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deletedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_AC6A4CA2979B1AD6 (company_id), INDEX IDX_AC6A4CA259027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_category (category_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_DDF4E35712469DE2 (category_id), INDEX IDX_DDF4E3574D16C4DD (shop_id), PRIMARY KEY(category_id, shop_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_currency (shop_id INT NOT NULL, currency_id INT NOT NULL, INDEX IDX_B2EE72A94D16C4DD (shop_id), INDEX IDX_B2EE72A938248176 (currency_id), PRIMARY KEY(shop_id, currency_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_locale (shop_id INT NOT NULL, locale_id INT NOT NULL, INDEX IDX_C422E01A4D16C4DD (shop_id), INDEX IDX_C422E01AE559DFD1 (locale_id), PRIMARY KEY(shop_id, locale_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_payment_method (payment_method_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_EBC0A0F05AA1164F (payment_method_id), INDEX IDX_EBC0A0F04D16C4DD (shop_id), PRIMARY KEY(payment_method_id, shop_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_producer (producer_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_4CDCB34A89B658FE (producer_id), INDEX IDX_4CDCB34A4D16C4DD (shop_id), PRIMARY KEY(producer_id, shop_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_product (product_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_D07944874584665A (product_id), INDEX IDX_D07944874D16C4DD (shop_id), PRIMARY KEY(product_id, shop_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, locale VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_661EB37F2C2AC5D34180C698 (translatable_id, locale), INDEX IDX_661EB37F2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA259027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE shop_category ADD CONSTRAINT FK_DDF4E35712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_category ADD CONSTRAINT FK_DDF4E3574D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_currency ADD CONSTRAINT FK_B2EE72A938248176 FOREIGN KEY (currency_id) REFERENCES currency (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_currency ADD CONSTRAINT FK_B2EE72A94D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_locale ADD CONSTRAINT FK_C422E01A4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_locale ADD CONSTRAINT FK_C422E01AE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_payment_method ADD CONSTRAINT FK_EBC0A0F04D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_payment_method ADD CONSTRAINT FK_EBC0A0F05AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_producer ADD CONSTRAINT FK_4CDCB34A4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_producer ADD CONSTRAINT FK_4CDCB34A89B658FE FOREIGN KEY (producer_id) REFERENCES producer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_product ADD CONSTRAINT FK_D07944874584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_product ADD CONSTRAINT FK_D07944874D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_translation ADD CONSTRAINT FK_661EB37F2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES shop (id) ON DELETE CASCADE');
    }
}
