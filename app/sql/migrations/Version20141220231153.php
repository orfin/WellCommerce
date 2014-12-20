<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141220231153 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE layout_box CHANGE settings settings LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', CHANGE visibility visibility INT DEFAULT 1 NOT NULL, CHANGE show_header show_header TINYINT(1) DEFAULT \'1\' NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE layout_box CHANGE settings settings LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', CHANGE visibility visibility INT DEFAULT 1, CHANGE show_header show_header TINYINT(1) DEFAULT \'1\'');
    }
}
