<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141226133746 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE path (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, identifier INT NOT NULL, locale VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE locale CHANGE code code VARCHAR(12) NOT NULL');
        $this->addSql('ALTER TABLE news ADD photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399507E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_1DD399507E9E4C8C ON news (photo_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE path');
        $this->addSql('ALTER TABLE Locale CHANGE code code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399507E9E4C8C');
        $this->addSql('DROP INDEX IDX_1DD399507E9E4C8C ON news');
        $this->addSql('ALTER TABLE news DROP photo_id');
    }
}
