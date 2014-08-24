<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140824225247 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE layout_box_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, vendor VARCHAR(255) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE layout_box ADD layout_box_type_id INT DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE layout_box ADD CONSTRAINT FK_9E93FB7991A674EA FOREIGN KEY (layout_box_type_id) REFERENCES layout_box_type (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_9E93FB7991A674EA ON layout_box (layout_box_type_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_box DROP FOREIGN KEY FK_9E93FB7991A674EA');
        $this->addSql('DROP TABLE layout_box_type');
        $this->addSql('DROP INDEX IDX_9E93FB7991A674EA ON layout_box');
        $this->addSql('ALTER TABLE layout_box ADD type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP layout_box_type_id');
    }
}
