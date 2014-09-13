<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140913132709 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE attribute_group (id INT AUTO_INCREMENT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy_id INT DEFAULT NULL, updatedBy_id INT DEFAULT NULL, deletedBy_id INT DEFAULT NULL, INDEX IDX_8EF8A7733174800F (createdBy_id), INDEX IDX_8EF8A77365FF1AEC (updatedBy_id), INDEX IDX_8EF8A77363D8C20E (deletedBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute_group_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_CC4A1CEE2C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_CC4A1CEE2C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute_group ADD CONSTRAINT FK_8EF8A7733174800F FOREIGN KEY (createdBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE attribute_group ADD CONSTRAINT FK_8EF8A77365FF1AEC FOREIGN KEY (updatedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE attribute_group ADD CONSTRAINT FK_8EF8A77363D8C20E FOREIGN KEY (deletedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE attribute_group_translation ADD CONSTRAINT FK_CC4A1CEE2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES attribute_group (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE attribute_group_translation DROP FOREIGN KEY FK_CC4A1CEE2C2AC5D3');
        $this->addSql('DROP TABLE attribute_group');
        $this->addSql('DROP TABLE attribute_group_translation');
    }
}
