<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140815193508 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70");
        $this->addSql("DROP INDEX IDX_64C19C1727ACA70 ON category");
        $this->addSql("ALTER TABLE category CHANGE parent_id parent INT DEFAULT NULL");
        $this->addSql("ALTER TABLE category ADD CONSTRAINT FK_64C19C13D8E604F FOREIGN KEY (parent) REFERENCES category (id)");
        $this->addSql("CREATE INDEX IDX_64C19C13D8E604F ON category (parent)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE category DROP FOREIGN KEY FK_64C19C13D8E604F");
        $this->addSql("DROP INDEX IDX_64C19C13D8E604F ON category");
        $this->addSql("ALTER TABLE category CHANGE parent parent_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)");
        $this->addSql("CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)");
    }
}
