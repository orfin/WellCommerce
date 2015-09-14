<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150914094148 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_C7440455444F97DD ON client');
        $this->addSql('ALTER TABLE client CHANGE discount discount NUMERIC(15, 4) NOT NULL, CHANGE phone phone VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE payment_method CHANGE enabled enabled TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE hierarchy hierarchy INT DEFAULT 0 NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client CHANGE discount discount NUMERIC(15, 4) DEFAULT NULL, CHANGE phone phone VARCHAR(60) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455444F97DD ON client (phone)');
        $this->addSql('ALTER TABLE payment_method CHANGE enabled enabled TINYINT(1) NOT NULL, CHANGE hierarchy hierarchy INT DEFAULT 0');
    }
}
