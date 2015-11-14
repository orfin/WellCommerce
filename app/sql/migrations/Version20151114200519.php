<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151114200519 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_review (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, nick VARCHAR(255) NOT NULL, review VARCHAR(255) NOT NULL, rating INT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_1B3FC0624584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_review ADD CONSTRAINT FK_1B3FC0624584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop ADD mailer_configuration_from VARCHAR(64) NOT NULL, ADD mailer_configuration_host VARCHAR(64) NOT NULL, ADD mailer_configuration_port INT NOT NULL, ADD mailer_configuration_user VARCHAR(64) NOT NULL, ADD mailer_configuration_pass VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE client ADD shop_id INT DEFAULT NULL, ADD resetPasswordHash VARCHAR(48) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404554D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C744045587E1A13C ON client (resetPasswordHash)');
        $this->addSql('CREATE INDEX IDX_C74404554D16C4DD ON client (shop_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE product_review');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404554D16C4DD');
        $this->addSql('DROP INDEX UNIQ_C744045587E1A13C ON client');
        $this->addSql('DROP INDEX IDX_C74404554D16C4DD ON client');
        $this->addSql('ALTER TABLE client DROP shop_id, DROP resetPasswordHash');
        $this->addSql('ALTER TABLE shop DROP mailer_configuration_from, DROP mailer_configuration_host, DROP mailer_configuration_port, DROP mailer_configuration_user, DROP mailer_configuration_pass');
    }
}
