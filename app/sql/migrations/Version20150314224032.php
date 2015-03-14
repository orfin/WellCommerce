<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150314224032 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shop_producer (producer_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_4CDCB34A89B658FE (producer_id), INDEX IDX_4CDCB34A4D16C4DD (shop_id), PRIMARY KEY(producer_id, shop_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop_producer ADD CONSTRAINT FK_4CDCB34A89B658FE FOREIGN KEY (producer_id) REFERENCES producer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_producer ADD CONSTRAINT FK_4CDCB34A4D16C4DD FOREIGN KEY (shop_id) REFERENCES Shop (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE shop_producer');
    }
}
