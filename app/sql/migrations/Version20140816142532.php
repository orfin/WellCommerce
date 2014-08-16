<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140816142532 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE shop_locale (shop_id INT NOT NULL, locale_id INT NOT NULL, INDEX IDX_C422E01A4D16C4DD (shop_id), INDEX IDX_C422E01AE559DFD1 (locale_id), PRIMARY KEY(shop_id, locale_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE shop_locale ADD CONSTRAINT FK_C422E01A4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE shop_locale ADD CONSTRAINT FK_C422E01AE559DFD1 FOREIGN KEY (locale_id) REFERENCES Locale (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE shop_locale");
    }
}
