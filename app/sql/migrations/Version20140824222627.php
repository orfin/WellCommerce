<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140824222627 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE layout_box (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, settings LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', visibility INT NOT NULL, show_header TINYINT(1) DEFAULT \'1\' NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE layout_box_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_D11E069A2C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_D11E069A2C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE layout_box_translation ADD CONSTRAINT FK_D11E069A2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES layout_box (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_box_translation DROP FOREIGN KEY FK_D11E069A2C2AC5D3');
        $this->addSql('DROP TABLE layout_box');
        $this->addSql('DROP TABLE layout_box_translation');
    }
}
