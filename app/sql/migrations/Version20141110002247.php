<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141110002247 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP INDEX uniq_919b011d2c2ac5d34180c698 ON dictionary_translation');
        $this->addSql('CREATE UNIQUE INDEX dictionary_translation_unique_translation ON dictionary_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_9d5cf3202c2ac5d34180c698 ON news_translation');
        $this->addSql('CREATE UNIQUE INDEX news_translation_unique_translation ON news_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_d81dadce2c2ac5d34180c698 ON availability_translation');
        $this->addSql('CREATE UNIQUE INDEX availability_translation_unique_translation ON availability_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_cd42885f2c2ac5d34180c698 ON deliverer_translation');
        $this->addSql('CREATE UNIQUE INDEX deliverer_translation_unique_translation ON deliverer_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_689f236b2c2ac5d34180c698 ON producer_translation');
        $this->addSql('CREATE UNIQUE INDEX producer_translation_unique_translation ON producer_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_3f207042c2ac5d34180c698 ON category_translation');
        $this->addSql('CREATE UNIQUE INDEX category_translation_unique_translation ON category_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_3bd74c602c2ac5d34180c698 ON tax_translation');
        $this->addSql('CREATE UNIQUE INDEX tax_translation_unique_translation ON tax_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_2f0e2f492c2ac5d34180c698 ON unit_translation');
        $this->addSql('CREATE UNIQUE INDEX unit_translation_unique_translation ON unit_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_dac5fad12c2ac5d34180c698 ON contact_translation');
        $this->addSql('CREATE UNIQUE INDEX contact_translation_unique_translation ON contact_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_bb9ab8bf2c2ac5d34180c698 ON client_group_translation');
        $this->addSql('CREATE UNIQUE INDEX client_group_translation_unique_translation ON client_group_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_4265b5e22c2ac5d34180c698 ON product_status_translation');
        $this->addSql('CREATE UNIQUE INDEX product_status_translation_unique_translation ON product_status_translation (translatable_id, locale)');
        $this->addSql('ALTER TABLE product_translation ADD route_pattern VARCHAR(64) NOT NULL');
        $this->addSql('DROP INDEX uniq_1846db702c2ac5d34180c698 ON product_translation');
        $this->addSql('CREATE UNIQUE INDEX product_translation_unique_translation ON product_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_3d44ebab2c2ac5d34180c698 ON payment_method_translation');
        $this->addSql('CREATE UNIQUE INDEX payment_method_translation_unique_translation ON payment_method_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_cc4a1cee2c2ac5d34180c698 ON attribute_group_translation');
        $this->addSql('CREATE UNIQUE INDEX attribute_group_translation_unique_translation ON attribute_group_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_89b5b6bf2c2ac5d34180c698 ON attribute_translation');
        $this->addSql('CREATE UNIQUE INDEX attribute_translation_unique_translation ON attribute_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_2b07bb0c2c2ac5d34180c698 ON attribute_value_translation');
        $this->addSql('CREATE UNIQUE INDEX attribute_value_translation_unique_translation ON attribute_value_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX uniq_d11e069a2c2ac5d34180c698 ON layout_box_translation');
        $this->addSql('CREATE UNIQUE INDEX layout_box_translation_unique_translation ON layout_box_translation (translatable_id, locale)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP INDEX attribute_group_translation_unique_translation ON attribute_group_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CC4A1CEE2C2AC5D34180C698 ON attribute_group_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX attribute_translation_unique_translation ON attribute_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_89B5B6BF2C2AC5D34180C698 ON attribute_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX attribute_value_translation_unique_translation ON attribute_value_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2B07BB0C2C2AC5D34180C698 ON attribute_value_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX availability_translation_unique_translation ON availability_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D81DADCE2C2AC5D34180C698 ON availability_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX category_translation_unique_translation ON category_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3F207042C2AC5D34180C698 ON category_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX client_group_translation_unique_translation ON client_group_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BB9AB8BF2C2AC5D34180C698 ON client_group_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX contact_translation_unique_translation ON contact_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DAC5FAD12C2AC5D34180C698 ON contact_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX deliverer_translation_unique_translation ON deliverer_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CD42885F2C2AC5D34180C698 ON deliverer_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX dictionary_translation_unique_translation ON dictionary_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_919B011D2C2AC5D34180C698 ON dictionary_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX layout_box_translation_unique_translation ON layout_box_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D11E069A2C2AC5D34180C698 ON layout_box_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX news_translation_unique_translation ON news_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9D5CF3202C2AC5D34180C698 ON news_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX payment_method_translation_unique_translation ON payment_method_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D44EBAB2C2AC5D34180C698 ON payment_method_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX producer_translation_unique_translation ON producer_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_689F236B2C2AC5D34180C698 ON producer_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX product_status_translation_unique_translation ON product_status_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4265B5E22C2AC5D34180C698 ON product_status_translation (translatable_id, locale)');
        $this->addSql('ALTER TABLE product_translation DROP route_pattern');
        $this->addSql('DROP INDEX product_translation_unique_translation ON product_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1846DB702C2AC5D34180C698 ON product_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX tax_translation_unique_translation ON tax_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BD74C602C2AC5D34180C698 ON tax_translation (translatable_id, locale)');
        $this->addSql('DROP INDEX unit_translation_unique_translation ON unit_translation');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F0E2F492C2AC5D34180C698 ON unit_translation (translatable_id, locale)');
    }
}
