<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141112164659 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE category_translation DROP FOREIGN KEY FK_3F2070434ECB4E6');
        $this->addSql('ALTER TABLE producer_translation DROP FOREIGN KEY FK_689F236B34ECB4E6');
        $this->addSql('ALTER TABLE product_translation DROP FOREIGN KEY FK_1846DB7034ECB4E6');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP INDEX UNIQ_689F236B34ECB4E6 ON producer_translation');
        $this->addSql('ALTER TABLE producer_translation DROP route_id, DROP defaults, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_3F2070434ECB4E6 ON category_translation');
        $this->addSql('ALTER TABLE category_translation DROP route_id, DROP defaults, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_1846DB7034ECB4E6 ON product_translation');
        $this->addSql('ALTER TABLE product_translation DROP route_id, DROP defaults, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, static_pattern VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, options LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', requirements LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', strategy VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, defaults LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_translation ADD route_id INT DEFAULT NULL, ADD defaults LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', CHANGE slug slug VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE category_translation ADD CONSTRAINT FK_3F2070434ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3F2070434ECB4E6 ON category_translation (route_id)');
        $this->addSql('ALTER TABLE producer_translation ADD route_id INT DEFAULT NULL, ADD defaults LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', CHANGE slug slug VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE producer_translation ADD CONSTRAINT FK_689F236B34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_689F236B34ECB4E6 ON producer_translation (route_id)');
        $this->addSql('ALTER TABLE product_translation ADD route_id INT DEFAULT NULL, ADD defaults LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', CHANGE slug slug VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE product_translation ADD CONSTRAINT FK_1846DB7034ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1846DB7034ECB4E6 ON product_translation (route_id)');
    }
}
