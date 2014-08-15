<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140815192918 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE category DROP INDEX UNIQ_64C19C1727ACA70, ADD INDEX IDX_64C19C1727ACA70 (parent_id)");
        $this->addSql("ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70");
        $this->addSql("ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE category DROP INDEX IDX_64C19C1727ACA70, ADD UNIQUE INDEX UNIQ_64C19C1727ACA70 (parent_id)");
        $this->addSql("ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70");
        $this->addSql("ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) ON DELETE CASCADE");
    }
}
