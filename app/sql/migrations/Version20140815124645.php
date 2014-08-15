<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140815124645 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE category_translation CHANGE short_description short_description LONGTEXT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE meta_title meta_title VARCHAR(255) DEFAULT NULL, CHANGE meta_keywords meta_keywords LONGTEXT DEFAULT NULL, CHANGE meta_description meta_description LONGTEXT DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE category_translation CHANGE short_description short_description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE description description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_title meta_title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE utf8_unicode_ci");
    }
}
