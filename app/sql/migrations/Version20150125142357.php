<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150125142357 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, order_status_group_id INT DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, deletedBy VARCHAR(255) DEFAULT NULL, INDEX IDX_B88F75C9A887BDC3 (order_status_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status_group (id INT AUTO_INCREMENT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, deletedBy VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status_group_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_BE35579E2C2AC5D3 (translatable_id), UNIQUE INDEX order_status_group_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_4C1EDBA82C2AC5D3 (translatable_id), UNIQUE INDEX order_status_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_status ADD CONSTRAINT FK_B88F75C9A887BDC3 FOREIGN KEY (order_status_group_id) REFERENCES order_status_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_status_group_translation ADD CONSTRAINT FK_BE35579E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES order_status_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_status_translation ADD CONSTRAINT FK_4C1EDBA82C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES order_status (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_status_translation DROP FOREIGN KEY FK_4C1EDBA82C2AC5D3');
        $this->addSql('ALTER TABLE order_status DROP FOREIGN KEY FK_B88F75C9A887BDC3');
        $this->addSql('ALTER TABLE order_status_group_translation DROP FOREIGN KEY FK_BE35579E2C2AC5D3');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE order_status_group');
        $this->addSql('DROP TABLE order_status_group_translation');
        $this->addSql('DROP TABLE order_status_translation');
    }
}
