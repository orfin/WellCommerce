<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140914201155 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE product_attribute ADD availability_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA597661778466 FOREIGN KEY (availability_id) REFERENCES availability (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_94DA597661778466 ON product_attribute (availability_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA597661778466');
        $this->addSql('DROP INDEX IDX_94DA597661778466 ON product_attribute');
        $this->addSql('ALTER TABLE product_attribute DROP availability_id');
    }
}
