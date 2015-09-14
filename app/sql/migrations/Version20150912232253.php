<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150912232253 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE producer_translation CHANGE short_description short_description LONGTEXT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9775E708ECA209CD ON theme (folder)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE producer_translation CHANGE short_description short_description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE description description LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX UNIQ_9775E708ECA209CD ON theme');
    }
}
