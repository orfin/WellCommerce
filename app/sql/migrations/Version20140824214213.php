<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140824214213 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE shop ADD layout_theme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA24771FAB0 FOREIGN KEY (layout_theme_id) REFERENCES layout_theme (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_AC6A4CA24771FAB0 ON shop (layout_theme_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA24771FAB0');
        $this->addSql('DROP INDEX IDX_AC6A4CA24771FAB0 ON shop');
        $this->addSql('ALTER TABLE shop DROP layout_theme_id');
    }
}
