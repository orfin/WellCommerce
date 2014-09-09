<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140909222835 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE client_address (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, street_no VARCHAR(255) DEFAULT NULL, flat_no VARCHAR(255) DEFAULT NULL, post_code VARCHAR(255) DEFAULT NULL, province VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(3) DEFAULT NULL, createdBy_id INT DEFAULT NULL, updatedBy_id INT DEFAULT NULL, deletedBy_id INT DEFAULT NULL, INDEX IDX_5F732BFC19EB6921 (client_id), INDEX IDX_5F732BFC3174800F (createdBy_id), INDEX IDX_5F732BFC65FF1AEC (updatedBy_id), INDEX IDX_5F732BFC63D8C20E (deletedBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_address ADD CONSTRAINT FK_5F732BFC19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_address ADD CONSTRAINT FK_5F732BFC3174800F FOREIGN KEY (createdBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE client_address ADD CONSTRAINT FK_5F732BFC65FF1AEC FOREIGN KEY (updatedBy_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE client_address ADD CONSTRAINT FK_5F732BFC63D8C20E FOREIGN KEY (deletedBy_id) REFERENCES users (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE client_address');
    }
}
