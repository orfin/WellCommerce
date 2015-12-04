<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151203232228 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_translation DROP FOREIGN KEY FK_DAC5FAD12C2AC5D3');
        $this->addSql('ALTER TABLE dictionary_translation DROP FOREIGN KEY FK_919B011D2C2AC5D3');
        $this->addSql('ALTER TABLE news_translation DROP FOREIGN KEY FK_9D5CF3202C2AC5D3');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, nick VARCHAR(255) NOT NULL, review VARCHAR(255) NOT NULL, rating INT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_794381C64584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C64584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE client_wishlist');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE contact_translation');
        $this->addSql('DROP TABLE dictionary');
        $this->addSql('DROP TABLE dictionary_translation');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_translation');
        $this->addSql('DROP TABLE product_review');
        $this->addSql('DROP TABLE smuggler_channel');
        $this->addSql('DROP TABLE smuggler_package');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F7E9E4C8C');
        $this->addSql('DROP INDEX IDX_4FBF094F7E9E4C8C ON company');
        $this->addSql('ALTER TABLE company DROP photo_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client_wishlist (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, product_id INT DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_B2071AF419EB6921 (client_id), INDEX IDX_B2071AF44584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, enabled TINYINT(1) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, updatedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deletedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, phone VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, business_hours LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, street VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, street_no VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, flat_no VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, post_code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, province VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, city VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, country VARCHAR(3) DEFAULT NULL COLLATE utf8_unicode_ci, locale VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX contact_translation_unique_translation (translatable_id, locale), INDEX IDX_DAC5FAD12C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dictionary (id INT AUTO_INCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, updatedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deletedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX dictionary_unique_idx (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dictionary_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, locale VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX dictionary_translation_unique_translation (translatable_id, locale), INDEX IDX_919B011D2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, photo_id INT DEFAULT NULL, publish TINYINT(1) DEFAULT \'1\' NOT NULL, startDate DATETIME DEFAULT NULL, endDate DATETIME DEFAULT NULL, featured TINYINT(1) DEFAULT \'0\' NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, updatedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deletedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_1DD399507E9E4C8C (photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, topic VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, summary LONGTEXT NOT NULL COLLATE utf8_unicode_ci, content LONGTEXT NOT NULL COLLATE utf8_unicode_ci, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, meta_description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, locale VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, slug VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX news_translation_unique_translation (translatable_id, locale), INDEX IDX_9D5CF3202C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_review (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, nick VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, review VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, rating INT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_1B3FC0624584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smuggler_channel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, url VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smuggler_package (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, vendor VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, local_version VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, remote_version VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_99F486E1DBC463C4 (full_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_wishlist ADD CONSTRAINT FK_B2071AF419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_wishlist ADD CONSTRAINT FK_B2071AF44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE contact_translation ADD CONSTRAINT FK_DAC5FAD12C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dictionary_translation ADD CONSTRAINT FK_919B011D2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES dictionary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399507E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE news_translation ADD CONSTRAINT FK_9D5CF3202C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_review ADD CONSTRAINT FK_1B3FC0624584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE review');
        $this->addSql('ALTER TABLE company ADD photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F7E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_4FBF094F7E9E4C8C ON company (photo_id)');
    }
}
