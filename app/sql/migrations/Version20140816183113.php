<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140816183113 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE producer_deliverer (deliverer_id INT NOT NULL, producer_id INT NOT NULL, INDEX IDX_93B0AE3DB6A6A3F4 (deliverer_id), INDEX IDX_93B0AE3D89B658FE (producer_id), PRIMARY KEY(deliverer_id, producer_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE producer_deliverer ADD CONSTRAINT FK_93B0AE3DB6A6A3F4 FOREIGN KEY (deliverer_id) REFERENCES deliverer (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE producer_deliverer ADD CONSTRAINT FK_93B0AE3D89B658FE FOREIGN KEY (producer_id) REFERENCES producer (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE producer_deliverer");
    }
}
