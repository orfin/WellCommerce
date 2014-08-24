<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140824223059 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE category ADD createdBy_id INT DEFAULT NULL, ADD updatedBy_id INT DEFAULT NULL, ADD deletedBy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C13174800F FOREIGN KEY (createdBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C165FF1AEC FOREIGN KEY (updatedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C163D8C20E FOREIGN KEY (deletedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_64C19C13174800F ON category (createdBy_id)');
        $this->addSql('CREATE INDEX IDX_64C19C165FF1AEC ON category (updatedBy_id)');
        $this->addSql('CREATE INDEX IDX_64C19C163D8C20E ON category (deletedBy_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C13174800F');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C165FF1AEC');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C163D8C20E');
        $this->addSql('DROP INDEX IDX_64C19C13174800F ON category');
        $this->addSql('DROP INDEX IDX_64C19C165FF1AEC ON category');
        $this->addSql('DROP INDEX IDX_64C19C163D8C20E ON category');
        $this->addSql('ALTER TABLE category DROP createdBy_id, DROP updatedBy_id, DROP deletedBy_id');
    }
}
