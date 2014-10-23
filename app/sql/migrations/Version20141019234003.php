<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141019234003 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE dictionary (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL, domain VARCHAR(64) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, UNIQUE INDEX dictionary_unique_idx (`key`, domain), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dictionary_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, translation VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_919B011D2C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_919B011D2C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dictionary_translation ADD CONSTRAINT FK_919B011D2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES dictionary (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE translation');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE dictionary_translation DROP FOREIGN KEY FK_919B011D2C2AC5D3');
        $this->addSql('CREATE TABLE translation (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, message VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, locale VARCHAR(12) NOT NULL COLLATE utf8_unicode_ci, domain VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, UNIQUE INDEX translation_unique_idx (`key`, domain), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE dictionary');
        $this->addSql('DROP TABLE dictionary_translation');
    }
}
