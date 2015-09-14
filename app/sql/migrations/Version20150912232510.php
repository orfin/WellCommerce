<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150912232510 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_translation CHANGE meta_title meta_title VARCHAR(255) DEFAULT NULL, CHANGE meta_keywords meta_keywords LONGTEXT DEFAULT NULL, CHANGE meta_description meta_description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE producer_translation CHANGE meta_title meta_title VARCHAR(255) DEFAULT NULL, CHANGE meta_keywords meta_keywords LONGTEXT DEFAULT NULL, CHANGE meta_description meta_description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE category_translation CHANGE meta_title meta_title VARCHAR(255) DEFAULT NULL, CHANGE meta_keywords meta_keywords LONGTEXT DEFAULT NULL, CHANGE meta_description meta_description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_translation CHANGE meta_title meta_title VARCHAR(255) DEFAULT NULL, CHANGE meta_keywords meta_keywords LONGTEXT DEFAULT NULL, CHANGE meta_description meta_description LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category_translation CHANGE meta_title meta_title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE page_translation CHANGE meta_title meta_title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE producer_translation CHANGE meta_title meta_title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE product_translation CHANGE meta_title meta_title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_keywords meta_keywords LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE meta_description meta_description LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
    }
}
