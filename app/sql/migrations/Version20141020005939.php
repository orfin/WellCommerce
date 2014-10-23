<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141020005939 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP INDEX dictionary_unique_idx ON dictionary');
        $this->addSql('ALTER TABLE dictionary CHANGE `key` identifier VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX dictionary_unique_idx ON dictionary (identifier, domain)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP INDEX dictionary_unique_idx ON dictionary');
        $this->addSql('ALTER TABLE dictionary CHANGE identifier `key` VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX dictionary_unique_idx ON dictionary (`key`, domain)');
    }
}
