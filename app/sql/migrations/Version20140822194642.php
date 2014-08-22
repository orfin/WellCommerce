<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140822194642 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE company ADD photo_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE company ADD CONSTRAINT FK_800230D37E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL");
        $this->addSql("CREATE INDEX IDX_800230D37E9E4C8C ON company (photo_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Company DROP FOREIGN KEY FK_800230D37E9E4C8C");
        $this->addSql("DROP INDEX IDX_800230D37E9E4C8C ON Company");
        $this->addSql("ALTER TABLE Company DROP photo_id");
    }
}
