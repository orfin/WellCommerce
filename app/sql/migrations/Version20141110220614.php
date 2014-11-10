<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141110220614 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE route ADD static_pattern VARCHAR(255) NOT NULL, ADD options LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', ADD requirements LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', ADD strategy VARCHAR(255) NOT NULL, DROP path, DROP type, DROP locale');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE route ADD path VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD locale VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP static_pattern, DROP options, DROP requirements, DROP strategy');
    }
}
