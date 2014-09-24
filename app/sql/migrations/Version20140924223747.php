<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140924223747 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE layout_page_column DROP FOREIGN KEY FK_5FAD17287E3A3C76');
        $this->addSql('ALTER TABLE layout_page_column_box DROP FOREIGN KEY FK_D950ED25FDFB89F4');
        $this->addSql('DROP TABLE layout_page');
        $this->addSql('DROP TABLE layout_page_column');
        $this->addSql('DROP TABLE layout_page_column_box');
        $this->addSql('ALTER TABLE news_translation ADD meta_title VARCHAR(255) DEFAULT NULL, ADD meta_keywords LONGTEXT DEFAULT NULL, ADD meta_description LONGTEXT DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL, DROP seo, DROP keywordTitle, DROP keyword, DROP keywordDescription');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE layout_page (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy_id INT DEFAULT NULL, updatedBy_id INT DEFAULT NULL, deletedBy_id INT DEFAULT NULL, INDEX IDX_FB499CB93174800F (createdBy_id), INDEX IDX_FB499CB965FF1AEC (updatedBy_id), INDEX IDX_FB499CB963D8C20E (deletedBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE layout_page_column (id INT AUTO_INCREMENT NOT NULL, layout_theme_id INT NOT NULL, layout_page_id INT NOT NULL, width INT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, hierarchy INT DEFAULT 0, INDEX IDX_5FAD17287E3A3C76 (layout_page_id), INDEX IDX_5FAD17284771FAB0 (layout_theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE layout_page_column_box (id INT AUTO_INCREMENT NOT NULL, layout_box_id INT DEFAULT NULL, layout_page_column_id INT NOT NULL, span INT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, hierarchy INT DEFAULT 0, INDEX IDX_D950ED25FDFB89F4 (layout_page_column_id), INDEX IDX_D950ED25A32F6CF9 (layout_box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE layout_page ADD CONSTRAINT FK_FB499CB93174800F FOREIGN KEY (createdBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE layout_page ADD CONSTRAINT FK_FB499CB963D8C20E FOREIGN KEY (deletedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE layout_page ADD CONSTRAINT FK_FB499CB965FF1AEC FOREIGN KEY (updatedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE layout_page_column ADD CONSTRAINT FK_5FAD17284771FAB0 FOREIGN KEY (layout_theme_id) REFERENCES layout_theme (id)');
        $this->addSql('ALTER TABLE layout_page_column ADD CONSTRAINT FK_5FAD17287E3A3C76 FOREIGN KEY (layout_page_id) REFERENCES layout_page (id)');
        $this->addSql('ALTER TABLE layout_page_column_box ADD CONSTRAINT FK_D950ED25A32F6CF9 FOREIGN KEY (layout_box_id) REFERENCES layout_box (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE layout_page_column_box ADD CONSTRAINT FK_D950ED25FDFB89F4 FOREIGN KEY (layout_page_column_id) REFERENCES layout_page_column (id)');
        $this->addSql('ALTER TABLE news_translation ADD keywordTitle VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD keyword VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD keywordDescription VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP meta_title, DROP meta_keywords, DROP meta_description, CHANGE slug seo VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
