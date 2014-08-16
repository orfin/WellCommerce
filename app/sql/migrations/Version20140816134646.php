<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140816134646 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE contact_translation CHANGE street street VARCHAR(255) DEFAULT NULL, CHANGE street_no street_no VARCHAR(255) DEFAULT NULL, CHANGE flat_no flat_no VARCHAR(255) DEFAULT NULL, CHANGE post_code post_code VARCHAR(255) DEFAULT NULL, CHANGE province province VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(3) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE contact_translation CHANGE street street VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE street_no street_no VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE flat_no flat_no VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE post_code post_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE province province VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE city city VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE country country VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci");
    }
}
