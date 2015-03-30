<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150315014739 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shop ADD theme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_C58E39C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C58E39C59027487 ON shop (theme_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Shop DROP FOREIGN KEY FK_C58E39C59027487');
        $this->addSql('DROP INDEX IDX_C58E39C59027487 ON Shop');
        $this->addSql('ALTER TABLE Shop DROP theme_id');
    }
}
