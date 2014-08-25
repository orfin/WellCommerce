<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140825200847 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_page_column ADD layout_theme_id INT NOT NULL');
        $this->addSql('ALTER TABLE layout_page_column ADD CONSTRAINT FK_5FAD17284771FAB0 FOREIGN KEY (layout_theme_id) REFERENCES layout_theme (id)');
        $this->addSql('CREATE INDEX IDX_5FAD17284771FAB0 ON layout_page_column (layout_theme_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_page_column DROP FOREIGN KEY FK_5FAD17284771FAB0');
        $this->addSql('DROP INDEX IDX_5FAD17284771FAB0 ON layout_page_column');
        $this->addSql('ALTER TABLE layout_page_column DROP layout_theme_id');
    }
}
