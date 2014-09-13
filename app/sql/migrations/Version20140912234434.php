<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140912234434 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE product_product_status (product_id INT NOT NULL, product_status_id INT NOT NULL, INDEX IDX_4A155A944584665A (product_id), INDEX IDX_4A155A94557B630 (product_status_id), PRIMARY KEY(product_id, product_status_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_status (id INT AUTO_INCREMENT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy_id INT DEFAULT NULL, updatedBy_id INT DEFAULT NULL, deletedBy_id INT DEFAULT NULL, INDEX IDX_197C24B83174800F (createdBy_id), INDEX IDX_197C24B865FF1AEC (updatedBy_id), INDEX IDX_197C24B863D8C20E (deletedBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_status_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_4265B5E22C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_4265B5E22C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_product_status ADD CONSTRAINT FK_4A155A944584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_status ADD CONSTRAINT FK_4A155A94557B630 FOREIGN KEY (product_status_id) REFERENCES product_status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_status ADD CONSTRAINT FK_197C24B83174800F FOREIGN KEY (createdBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product_status ADD CONSTRAINT FK_197C24B865FF1AEC FOREIGN KEY (updatedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product_status ADD CONSTRAINT FK_197C24B863D8C20E FOREIGN KEY (deletedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product_status_translation ADD CONSTRAINT FK_4265B5E22C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES product_status (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE product_product_status DROP FOREIGN KEY FK_4A155A94557B630');
        $this->addSql('ALTER TABLE product_status_translation DROP FOREIGN KEY FK_4265B5E22C2AC5D3');
        $this->addSql('DROP TABLE product_product_status');
        $this->addSql('DROP TABLE product_status');
        $this->addSql('DROP TABLE product_status_translation');
    }
}
