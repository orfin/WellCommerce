<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140810225703 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE client_group_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_BB9AB8BF2C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_BB9AB8BF2C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE client_group_translation ADD CONSTRAINT FK_BB9AB8BF2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES client_group (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE client_group ADD name TINYTEXT DEFAULT NULL, ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, DROP created_at, DROP updated_at");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE client_group_translation");
        $this->addSql("ALTER TABLE client_group ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP name, DROP createdAt, DROP updatedAt");
    }
}
