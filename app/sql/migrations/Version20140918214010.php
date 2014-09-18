<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140918214010 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE product ADD attribute_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD62D643B7 FOREIGN KEY (attribute_group_id) REFERENCES attribute_group (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_D34A04AD62D643B7 ON product (attribute_group_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD62D643B7');
        $this->addSql('DROP INDEX IDX_D34A04AD62D643B7 ON product');
        $this->addSql('ALTER TABLE product DROP attribute_group_id');
    }
}
