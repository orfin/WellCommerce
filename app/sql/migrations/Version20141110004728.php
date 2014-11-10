<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141110004728 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE product_translation ADD route_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_translation ADD CONSTRAINT FK_1846DB7034ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1846DB7034ECB4E6 ON product_translation (route_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE product_translation DROP FOREIGN KEY FK_1846DB7034ECB4E6');
        $this->addSql('DROP INDEX UNIQ_1846DB7034ECB4E6 ON product_translation');
        $this->addSql('ALTER TABLE product_translation DROP route_id');
    }
}
