<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141226010039 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE news_photo');
        $this->addSql('DROP TABLE settings');
        $this->addSql('ALTER TABLE locale CHANGE code code VARCHAR(12) NOT NULL');
        $this->addSql('ALTER TABLE news ADD photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399507E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_1DD399507E9E4C8C ON news (photo_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE news_photo (id INT AUTO_INCREMENT NOT NULL, photo_id INT NOT NULL, news_id INT NOT NULL, main_photo TINYINT(1) DEFAULT \'0\' NOT NULL, hierarchy INT DEFAULT 0, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_6E0803467E9E4C8C (photo_id), INDEX IDX_6E080346B5A459A0 (news_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, namespace VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, param VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, value VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, updatedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deletedBy VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news_photo ADD CONSTRAINT FK_6E0803467E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE news_photo ADD CONSTRAINT FK_6E080346B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('ALTER TABLE Locale CHANGE code code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399507E9E4C8C');
        $this->addSql('DROP INDEX IDX_1DD399507E9E4C8C ON news');
        $this->addSql('ALTER TABLE news DROP photo_id');
    }
}
