<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141109131721 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE dictionary_translation DROP FOREIGN KEY FK_919B011DE559DFD1');
        $this->addSql('DROP INDEX IDX_919B011DE559DFD1 ON dictionary_translation');
        $this->addSql('ALTER TABLE dictionary_translation DROP locale_id');
        $this->addSql('ALTER TABLE news_translation DROP FOREIGN KEY FK_9D5CF320E559DFD1');
        $this->addSql('DROP INDEX IDX_9D5CF320E559DFD1 ON news_translation');
        $this->addSql('ALTER TABLE news_translation DROP locale_id');
        $this->addSql('ALTER TABLE availability_translation DROP FOREIGN KEY FK_D81DADCEE559DFD1');
        $this->addSql('DROP INDEX IDX_D81DADCEE559DFD1 ON availability_translation');
        $this->addSql('ALTER TABLE availability_translation DROP locale_id');
        $this->addSql('ALTER TABLE deliverer_translation DROP FOREIGN KEY FK_CD42885FE559DFD1');
        $this->addSql('DROP INDEX IDX_CD42885FE559DFD1 ON deliverer_translation');
        $this->addSql('ALTER TABLE deliverer_translation DROP locale_id');
        $this->addSql('ALTER TABLE producer_translation DROP FOREIGN KEY FK_689F236BE559DFD1');
        $this->addSql('DROP INDEX IDX_689F236BE559DFD1 ON producer_translation');
        $this->addSql('ALTER TABLE producer_translation DROP locale_id');
        $this->addSql('ALTER TABLE category_translation DROP FOREIGN KEY FK_3F20704E559DFD1');
        $this->addSql('DROP INDEX IDX_3F20704E559DFD1 ON category_translation');
        $this->addSql('ALTER TABLE category_translation DROP locale_id');
        $this->addSql('ALTER TABLE tax_translation DROP FOREIGN KEY FK_3BD74C60E559DFD1');
        $this->addSql('DROP INDEX IDX_3BD74C60E559DFD1 ON tax_translation');
        $this->addSql('ALTER TABLE tax_translation DROP locale_id');
        $this->addSql('ALTER TABLE unit_translation DROP FOREIGN KEY FK_2F0E2F49E559DFD1');
        $this->addSql('DROP INDEX IDX_2F0E2F49E559DFD1 ON unit_translation');
        $this->addSql('ALTER TABLE unit_translation DROP locale_id');
        $this->addSql('ALTER TABLE contact_translation DROP FOREIGN KEY FK_DAC5FAD1E559DFD1');
        $this->addSql('DROP INDEX IDX_DAC5FAD1E559DFD1 ON contact_translation');
        $this->addSql('ALTER TABLE contact_translation DROP locale_id');
        $this->addSql('ALTER TABLE client_group_translation DROP FOREIGN KEY FK_BB9AB8BFE559DFD1');
        $this->addSql('DROP INDEX IDX_BB9AB8BFE559DFD1 ON client_group_translation');
        $this->addSql('ALTER TABLE client_group_translation DROP locale_id');
        $this->addSql('ALTER TABLE product_status_translation DROP FOREIGN KEY FK_4265B5E2E559DFD1');
        $this->addSql('DROP INDEX IDX_4265B5E2E559DFD1 ON product_status_translation');
        $this->addSql('ALTER TABLE product_status_translation DROP locale_id');
        $this->addSql('ALTER TABLE product_translation DROP FOREIGN KEY FK_1846DB70E559DFD1');
        $this->addSql('DROP INDEX IDX_1846DB70E559DFD1 ON product_translation');
        $this->addSql('ALTER TABLE product_translation DROP locale_id');
        $this->addSql('ALTER TABLE payment_method_translation DROP FOREIGN KEY FK_3D44EBABE559DFD1');
        $this->addSql('DROP INDEX IDX_3D44EBABE559DFD1 ON payment_method_translation');
        $this->addSql('ALTER TABLE payment_method_translation DROP locale_id');
        $this->addSql('ALTER TABLE attribute_group_translation DROP FOREIGN KEY FK_CC4A1CEEE559DFD1');
        $this->addSql('DROP INDEX IDX_CC4A1CEEE559DFD1 ON attribute_group_translation');
        $this->addSql('ALTER TABLE attribute_group_translation DROP locale_id');
        $this->addSql('ALTER TABLE attribute_translation DROP FOREIGN KEY FK_89B5B6BFE559DFD1');
        $this->addSql('DROP INDEX IDX_89B5B6BFE559DFD1 ON attribute_translation');
        $this->addSql('ALTER TABLE attribute_translation DROP locale_id');
        $this->addSql('ALTER TABLE attribute_value_translation DROP FOREIGN KEY FK_2B07BB0CE559DFD1');
        $this->addSql('DROP INDEX IDX_2B07BB0CE559DFD1 ON attribute_value_translation');
        $this->addSql('ALTER TABLE attribute_value_translation DROP locale_id');
        $this->addSql('ALTER TABLE layout_box_translation DROP FOREIGN KEY FK_D11E069AE559DFD1');
        $this->addSql('DROP INDEX IDX_D11E069AE559DFD1 ON layout_box_translation');
        $this->addSql('ALTER TABLE layout_box_translation DROP locale_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE attribute_group_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attribute_group_translation ADD CONSTRAINT FK_CC4A1CEEE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_CC4A1CEEE559DFD1 ON attribute_group_translation (locale_id)');
        $this->addSql('ALTER TABLE attribute_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attribute_translation ADD CONSTRAINT FK_89B5B6BFE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_89B5B6BFE559DFD1 ON attribute_translation (locale_id)');
        $this->addSql('ALTER TABLE attribute_value_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attribute_value_translation ADD CONSTRAINT FK_2B07BB0CE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_2B07BB0CE559DFD1 ON attribute_value_translation (locale_id)');
        $this->addSql('ALTER TABLE availability_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE availability_translation ADD CONSTRAINT FK_D81DADCEE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D81DADCEE559DFD1 ON availability_translation (locale_id)');
        $this->addSql('ALTER TABLE category_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category_translation ADD CONSTRAINT FK_3F20704E559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_3F20704E559DFD1 ON category_translation (locale_id)');
        $this->addSql('ALTER TABLE client_group_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client_group_translation ADD CONSTRAINT FK_BB9AB8BFE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_BB9AB8BFE559DFD1 ON client_group_translation (locale_id)');
        $this->addSql('ALTER TABLE contact_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_translation ADD CONSTRAINT FK_DAC5FAD1E559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_DAC5FAD1E559DFD1 ON contact_translation (locale_id)');
        $this->addSql('ALTER TABLE deliverer_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deliverer_translation ADD CONSTRAINT FK_CD42885FE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_CD42885FE559DFD1 ON deliverer_translation (locale_id)');
        $this->addSql('ALTER TABLE dictionary_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dictionary_translation ADD CONSTRAINT FK_919B011DE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_919B011DE559DFD1 ON dictionary_translation (locale_id)');
        $this->addSql('ALTER TABLE layout_box_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE layout_box_translation ADD CONSTRAINT FK_D11E069AE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D11E069AE559DFD1 ON layout_box_translation (locale_id)');
        $this->addSql('ALTER TABLE news_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE news_translation ADD CONSTRAINT FK_9D5CF320E559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_9D5CF320E559DFD1 ON news_translation (locale_id)');
        $this->addSql('ALTER TABLE payment_method_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment_method_translation ADD CONSTRAINT FK_3D44EBABE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_3D44EBABE559DFD1 ON payment_method_translation (locale_id)');
        $this->addSql('ALTER TABLE producer_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE producer_translation ADD CONSTRAINT FK_689F236BE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_689F236BE559DFD1 ON producer_translation (locale_id)');
        $this->addSql('ALTER TABLE product_status_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_status_translation ADD CONSTRAINT FK_4265B5E2E559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4265B5E2E559DFD1 ON product_status_translation (locale_id)');
        $this->addSql('ALTER TABLE product_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_translation ADD CONSTRAINT FK_1846DB70E559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_1846DB70E559DFD1 ON product_translation (locale_id)');
        $this->addSql('ALTER TABLE tax_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tax_translation ADD CONSTRAINT FK_3BD74C60E559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_3BD74C60E559DFD1 ON tax_translation (locale_id)');
        $this->addSql('ALTER TABLE unit_translation ADD locale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unit_translation ADD CONSTRAINT FK_2F0E2F49E559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_2F0E2F49E559DFD1 ON unit_translation (locale_id)');
    }
}
