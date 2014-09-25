<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140925221646 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_box_type ADD createdBy_id INT DEFAULT NULL, ADD updatedBy_id INT DEFAULT NULL, ADD deletedBy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE layout_box_type ADD CONSTRAINT FK_64C995173174800F FOREIGN KEY (createdBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE layout_box_type ADD CONSTRAINT FK_64C9951765FF1AEC FOREIGN KEY (updatedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE layout_box_type ADD CONSTRAINT FK_64C9951763D8C20E FOREIGN KEY (deletedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_64C995173174800F ON layout_box_type (createdBy_id)');
        $this->addSql('CREATE INDEX IDX_64C9951765FF1AEC ON layout_box_type (updatedBy_id)');
        $this->addSql('CREATE INDEX IDX_64C9951763D8C20E ON layout_box_type (deletedBy_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_box_type DROP FOREIGN KEY FK_64C995173174800F');
        $this->addSql('ALTER TABLE layout_box_type DROP FOREIGN KEY FK_64C9951765FF1AEC');
        $this->addSql('ALTER TABLE layout_box_type DROP FOREIGN KEY FK_64C9951763D8C20E');
        $this->addSql('DROP INDEX IDX_64C995173174800F ON layout_box_type');
        $this->addSql('DROP INDEX IDX_64C9951765FF1AEC ON layout_box_type');
        $this->addSql('DROP INDEX IDX_64C9951763D8C20E ON layout_box_type');
        $this->addSql('ALTER TABLE layout_box_type DROP createdBy_id, DROP updatedBy_id, DROP deletedBy_id');
    }
}
