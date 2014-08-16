<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140816174527 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE producer (id INT AUTO_INCREMENT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE shop_producer (producer_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_4CDCB34A89B658FE (producer_id), INDEX IDX_4CDCB34A4D16C4DD (shop_id), PRIMARY KEY(producer_id, shop_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE producer_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, short_description LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, INDEX IDX_689F236B2C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_689F236B2C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE shop_producer ADD CONSTRAINT FK_4CDCB34A89B658FE FOREIGN KEY (producer_id) REFERENCES producer (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE shop_producer ADD CONSTRAINT FK_4CDCB34A4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE producer_translation ADD CONSTRAINT FK_689F236B2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES producer (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE shop_producer DROP FOREIGN KEY FK_4CDCB34A89B658FE");
        $this->addSql("ALTER TABLE producer_translation DROP FOREIGN KEY FK_689F236B2C2AC5D3");
        $this->addSql("DROP TABLE producer");
        $this->addSql("DROP TABLE shop_producer");
        $this->addSql("DROP TABLE producer_translation");
    }
}
