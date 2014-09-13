<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140913143855 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy_id INT DEFAULT NULL, updatedBy_id INT DEFAULT NULL, deletedBy_id INT DEFAULT NULL, INDEX IDX_FA7AEFFB3174800F (createdBy_id), INDEX IDX_FA7AEFFB65FF1AEC (updatedBy_id), INDEX IDX_FA7AEFFB63D8C20E (deletedBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_89B5B6BF2C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_89B5B6BF2C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute_value (id INT AUTO_INCREMENT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy_id INT DEFAULT NULL, updatedBy_id INT DEFAULT NULL, deletedBy_id INT DEFAULT NULL, INDEX IDX_FE4FBB823174800F (createdBy_id), INDEX IDX_FE4FBB8265FF1AEC (updatedBy_id), INDEX IDX_FE4FBB8263D8C20E (deletedBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute_value_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_2B07BB0C2C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_2B07BB0C2C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFB3174800F FOREIGN KEY (createdBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFB65FF1AEC FOREIGN KEY (updatedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFB63D8C20E FOREIGN KEY (deletedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE attribute_translation ADD CONSTRAINT FK_89B5B6BF2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribute_value ADD CONSTRAINT FK_FE4FBB823174800F FOREIGN KEY (createdBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE attribute_value ADD CONSTRAINT FK_FE4FBB8265FF1AEC FOREIGN KEY (updatedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE attribute_value ADD CONSTRAINT FK_FE4FBB8263D8C20E FOREIGN KEY (deletedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE attribute_value_translation ADD CONSTRAINT FK_2B07BB0C2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES attribute_value (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE attribute_translation DROP FOREIGN KEY FK_89B5B6BF2C2AC5D3');
        $this->addSql('ALTER TABLE attribute_value_translation DROP FOREIGN KEY FK_2B07BB0C2C2AC5D3');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE attribute_translation');
        $this->addSql('DROP TABLE attribute_value');
        $this->addSql('DROP TABLE attribute_value_translation');
    }
}
