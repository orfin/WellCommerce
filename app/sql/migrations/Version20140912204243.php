<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140912204243 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, publish TINYINT(1) DEFAULT \'0\' NOT NULL, startDate DATETIME DEFAULT NULL, endDate DATETIME DEFAULT NULL, featured TINYINT(1) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy_id INT DEFAULT NULL, updatedBy_id INT DEFAULT NULL, deletedBy_id INT DEFAULT NULL, INDEX IDX_1DD399503174800F (createdBy_id), INDEX IDX_1DD3995065FF1AEC (updatedBy_id), INDEX IDX_1DD3995063D8C20E (deletedBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_photo (id INT AUTO_INCREMENT NOT NULL, photo_id INT NOT NULL, news_id INT NOT NULL, main_photo TINYINT(1) DEFAULT \'0\' NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, hierarchy INT DEFAULT 0, INDEX IDX_6E0803467E9E4C8C (photo_id), INDEX IDX_6E080346B5A459A0 (news_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, topic VARCHAR(255) NOT NULL, summary LONGTEXT NOT NULL, content LONGTEXT NOT NULL, seo VARCHAR(255) NOT NULL, keywordTitle VARCHAR(255) NOT NULL, keyword VARCHAR(255) NOT NULL, keywordDescription VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_9D5CF3202C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_9D5CF3202C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399503174800F FOREIGN KEY (createdBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995065FF1AEC FOREIGN KEY (updatedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995063D8C20E FOREIGN KEY (deletedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE news_photo ADD CONSTRAINT FK_6E0803467E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE news_photo ADD CONSTRAINT FK_6E080346B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('ALTER TABLE news_translation ADD CONSTRAINT FK_9D5CF3202C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES news (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE news_photo DROP FOREIGN KEY FK_6E080346B5A459A0');
        $this->addSql('ALTER TABLE news_translation DROP FOREIGN KEY FK_9D5CF3202C2AC5D3');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_photo');
        $this->addSql('DROP TABLE news_translation');
    }
}
