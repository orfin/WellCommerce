<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141112004038 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE producer_translation ADD route_id INT DEFAULT NULL, CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE producer_translation ADD CONSTRAINT FK_689F236B34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_689F236B34ECB4E6 ON producer_translation (route_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE producer_translation DROP FOREIGN KEY FK_689F236B34ECB4E6');
        $this->addSql('DROP INDEX UNIQ_689F236B34ECB4E6 ON producer_translation');
        $this->addSql('ALTER TABLE producer_translation DROP route_id, CHANGE slug slug VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
