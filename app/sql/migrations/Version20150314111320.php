<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150314111320 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Shop (id INT AUTO_INCREMENT NOT NULL, photo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, deletedBy VARCHAR(255) DEFAULT NULL, INDEX IDX_C58E39C7E9E4C8C (photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Shop ADD CONSTRAINT FK_C58E39C7E9E4C8C FOREIGN KEY (photo_id) REFERENCES media (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Shop');
    }
}
