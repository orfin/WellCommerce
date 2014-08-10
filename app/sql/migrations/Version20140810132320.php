<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140810132320 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP INDEX client_group_translation_idx ON client_group_translation");
        $this->addSql("ALTER TABLE client_group_translation ADD language_id INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD client_group_id INT NOT NULL, DROP locale, DROP field, DROP foreign_key, DROP content, CHANGE object_class name VARCHAR(255) NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE client_group_translation ADD locale VARCHAR(8) NOT NULL COLLATE utf8_unicode_ci, ADD field VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci, ADD foreign_key VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci, ADD content LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, DROP language_id, DROP created_at, DROP updated_at, DROP client_group_id, CHANGE name object_class VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci");
        $this->addSql("CREATE INDEX client_group_translation_idx ON client_group_translation (locale, object_class, field, foreign_key)");
    }
}
