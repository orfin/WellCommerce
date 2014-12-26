<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141226184058 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE route_page DROP INDEX UNIQ_B94FB7A5CD42CE46, ADD INDEX IDX_B94FB7A5CD42CE46 (foreign_id)');
        $this->addSql('ALTER TABLE route_producer DROP INDEX UNIQ_694801F7CD42CE46, ADD INDEX IDX_694801F7CD42CE46 (foreign_id)');
        $this->addSql('ALTER TABLE route_category DROP INDEX UNIQ_F86051EACD42CE46, ADD INDEX IDX_F86051EACD42CE46 (foreign_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE route_category DROP INDEX IDX_F86051EACD42CE46, ADD UNIQUE INDEX UNIQ_F86051EACD42CE46 (foreign_id)');
        $this->addSql('ALTER TABLE route_page DROP INDEX IDX_B94FB7A5CD42CE46, ADD UNIQUE INDEX UNIQ_B94FB7A5CD42CE46 (foreign_id)');
        $this->addSql('ALTER TABLE route_producer DROP INDEX IDX_694801F7CD42CE46, ADD UNIQUE INDEX UNIQ_694801F7CD42CE46 (foreign_id)');
    }
}
