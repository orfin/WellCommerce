<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140816213658 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE users ADD email VARCHAR(60) NOT NULL, ADD is_active TINYINT(1) NOT NULL, DROP roles, CHANGE username username VARCHAR(25) NOT NULL, CHANGE password password VARCHAR(64) NOT NULL, CHANGE salt salt VARCHAR(60) NOT NULL");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP INDEX UNIQ_1483A5E9F85E0677 ON users");
        $this->addSql("DROP INDEX UNIQ_1483A5E9E7927C74 ON users");
        $this->addSql("ALTER TABLE users ADD roles VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP email, DROP is_active, CHANGE username username VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE password password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE salt salt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci");
    }
}
