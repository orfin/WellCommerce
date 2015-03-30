<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150314161312 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shop ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_C58E39C979B1AD6 FOREIGN KEY (company_id) REFERENCES Company (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C58E39C979B1AD6 ON shop (company_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Shop DROP FOREIGN KEY FK_C58E39C979B1AD6');
        $this->addSql('DROP INDEX IDX_C58E39C979B1AD6 ON Shop');
        $this->addSql('ALTER TABLE Shop DROP company_id');
    }
}
