<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140814221706 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE Contact (id INT AUTO_INCREMENT NOT NULL, enabled TINYINT(1) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE contact_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, street_no VARCHAR(255) NOT NULL, flat_no VARCHAR(255) NOT NULL, post_code VARCHAR(255) NOT NULL, province VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, business_hours LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_DAC5FAD12C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_DAC5FAD12C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE contact_translation ADD CONSTRAINT FK_DAC5FAD12C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES Contact (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE contact_translation DROP FOREIGN KEY FK_DAC5FAD12C2AC5D3");
        $this->addSql("DROP TABLE Contact");
        $this->addSql("DROP TABLE contact_translation");
    }
}
