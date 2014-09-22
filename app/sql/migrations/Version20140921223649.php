<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140921223649 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_box ADD layout_theme_id INT NOT NULL');
        $this->addSql('ALTER TABLE layout_box ADD CONSTRAINT FK_9E93FB794771FAB0 FOREIGN KEY (layout_theme_id) REFERENCES layout_theme (id)');
        $this->addSql('CREATE INDEX IDX_9E93FB794771FAB0 ON layout_box (layout_theme_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_box DROP FOREIGN KEY FK_9E93FB794771FAB0');
        $this->addSql('DROP INDEX IDX_9E93FB794771FAB0 ON layout_box');
        $this->addSql('ALTER TABLE layout_box DROP layout_theme_id');
    }
}
