<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140812214034 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE tax_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_3BD74C602C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_3BD74C602C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE tax_translation ADD CONSTRAINT FK_3BD74C602C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tax (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE tax ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, DROP created_at, DROP updated_at, CHANGE value value NUMERIC(15, 4) NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE tax_translation");
        $this->addSql("ALTER TABLE tax ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP createdAt, DROP updatedAt, CHANGE value value NUMERIC(10, 0) NOT NULL");
    }
}
