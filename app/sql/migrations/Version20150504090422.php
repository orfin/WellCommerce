<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150504090422 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE route_product_status (id INT NOT NULL, foreign_id INT DEFAULT NULL, INDEX IDX_492A8C99CD42CE46 (foreign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE route_product_status ADD CONSTRAINT FK_492A8C99CD42CE46 FOREIGN KEY (foreign_id) REFERENCES product_status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE route_product_status ADD CONSTRAINT FK_492A8C99BF396750 FOREIGN KEY (id) REFERENCES route (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD44813F90');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD738AA936');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADB2A824D8');
        $this->addSql('DROP INDEX IDX_D34A04ADB2A824D8 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD738AA936 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD44813F90 ON product');
        $this->addSql('ALTER TABLE product ADD buy_price_amount NUMERIC(15, 4) NOT NULL, ADD buy_price_tax INT NOT NULL, ADD buy_price_currency INT NOT NULL, ADD sell_price_amount NUMERIC(15, 4) NOT NULL, ADD sell_price_tax INT NOT NULL, ADD sell_price_currency INT NOT NULL, ADD dimension_depth NUMERIC(15, 4) NOT NULL, ADD dimension_width NUMERIC(15, 4) NOT NULL, ADD dimension_height NUMERIC(15, 4) NOT NULL, DROP sell_currency_id, DROP buy_currency_id, DROP tax_id, DROP buy_price, DROP sell_price, DROP width, DROP height, DROP depth');
        $this->addSql('ALTER TABLE product_status_translation ADD route_id INT DEFAULT NULL, ADD meta_title VARCHAR(255) DEFAULT NULL, ADD meta_keywords LONGTEXT DEFAULT NULL, ADD meta_description LONGTEXT DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product_status_translation ADD CONSTRAINT FK_4265B5E234ECB4E6 FOREIGN KEY (route_id) REFERENCES route_product_status (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4265B5E234ECB4E6 ON product_status_translation (route_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_status_translation DROP FOREIGN KEY FK_4265B5E234ECB4E6');
        $this->addSql('DROP TABLE route_product_status');
        $this->addSql('ALTER TABLE product ADD sell_currency_id INT DEFAULT NULL, ADD buy_currency_id INT DEFAULT NULL, ADD tax_id INT DEFAULT NULL, ADD buy_price NUMERIC(15, 4) NOT NULL, ADD sell_price NUMERIC(15, 4) NOT NULL, ADD width NUMERIC(15, 4) NOT NULL, ADD height NUMERIC(15, 4) NOT NULL, ADD depth NUMERIC(15, 4) NOT NULL, DROP buy_price_amount, DROP buy_price_tax, DROP buy_price_currency, DROP sell_price_amount, DROP sell_price_tax, DROP sell_price_currency, DROP dimension_depth, DROP dimension_width, DROP dimension_height');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD44813F90 FOREIGN KEY (sell_currency_id) REFERENCES currency (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD738AA936 FOREIGN KEY (buy_currency_id) REFERENCES currency (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADB2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_D34A04ADB2A824D8 ON product (tax_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD738AA936 ON product (buy_currency_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD44813F90 ON product (sell_currency_id)');
        $this->addSql('DROP INDEX UNIQ_4265B5E234ECB4E6 ON product_status_translation');
        $this->addSql('ALTER TABLE product_status_translation DROP route_id, DROP meta_title, DROP meta_keywords, DROP meta_description, DROP slug');
    }
}
