<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140822215356 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE product ADD buy_currency_id INT DEFAULT NULL, ADD sell_currency_id INT DEFAULT NULL, ADD buy_price NUMERIC(15, 4) NOT NULL, ADD sell_price NUMERIC(15, 4) NOT NULL, ADD track_stock TINYINT(1) NOT NULL");
        $this->addSql("ALTER TABLE product ADD CONSTRAINT FK_D34A04AD738AA936 FOREIGN KEY (buy_currency_id) REFERENCES currency (id) ON DELETE SET NULL");
        $this->addSql("ALTER TABLE product ADD CONSTRAINT FK_D34A04AD44813F90 FOREIGN KEY (sell_currency_id) REFERENCES currency (id) ON DELETE SET NULL");
        $this->addSql("CREATE INDEX IDX_D34A04AD738AA936 ON product (buy_currency_id)");
        $this->addSql("CREATE INDEX IDX_D34A04AD44813F90 ON product (sell_currency_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD738AA936");
        $this->addSql("ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD44813F90");
        $this->addSql("DROP INDEX IDX_D34A04AD738AA936 ON product");
        $this->addSql("DROP INDEX IDX_D34A04AD44813F90 ON product");
        $this->addSql("ALTER TABLE product DROP buy_currency_id, DROP sell_currency_id, DROP buy_price, DROP sell_price, DROP track_stock");
    }
}
