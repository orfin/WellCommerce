<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140827213112 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE shop_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, INDEX IDX_661EB37F2C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_661EB37F2C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop_translation ADD CONSTRAINT FK_661EB37F2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop DROP name');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE shop_translation');
        $this->addSql('ALTER TABLE shop ADD name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
