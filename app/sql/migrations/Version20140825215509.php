<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140825215509 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_page_column_box ADD layout_box_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE layout_page_column_box ADD CONSTRAINT FK_D950ED25A32F6CF9 FOREIGN KEY (layout_box_id) REFERENCES layout_box (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D950ED25A32F6CF9 ON layout_page_column_box (layout_box_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_page_column_box DROP FOREIGN KEY FK_D950ED25A32F6CF9');
        $this->addSql('DROP INDEX IDX_D950ED25A32F6CF9 ON layout_page_column_box');
        $this->addSql('ALTER TABLE layout_page_column_box DROP layout_box_id');
    }
}
