<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140807013702 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE company CHANGE short_name short_name VARCHAR(255) DEFAULT NULL, CHANGE street street VARCHAR(255) DEFAULT NULL, CHANGE street_no street_no VARCHAR(255) DEFAULT NULL, CHANGE flat_no flat_no VARCHAR(255) DEFAULT NULL, CHANGE post_code post_code VARCHAR(255) DEFAULT NULL, CHANGE province province VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(3) DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Company CHANGE short_name short_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE street street VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE street_no street_no VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE flat_no flat_no VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE post_code post_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE province province VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE country country VARCHAR(3) NOT NULL COLLATE utf8_unicode_ci, CHANGE updated_at updated_at DATETIME NOT NULL");
    }
}
