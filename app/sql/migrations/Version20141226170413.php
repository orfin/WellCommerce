<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141226170413 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_translation ADD route_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_translation ADD CONSTRAINT FK_A3D51B1D34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3D51B1D34ECB4E6 ON page_translation (route_id)');
        $this->addSql('ALTER TABLE producer_translation ADD route_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE producer_translation ADD CONSTRAINT FK_689F236B34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_689F236B34ECB4E6 ON producer_translation (route_id)');
        $this->addSql('ALTER TABLE category_translation ADD route_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category_translation ADD CONSTRAINT FK_3F2070434ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3F2070434ECB4E6 ON category_translation (route_id)');
        $this->addSql('ALTER TABLE product_translation DROP FOREIGN KEY FK_1846DB70D96C566B');
        $this->addSql('DROP INDEX UNIQ_1846DB70D96C566B ON product_translation');
        $this->addSql('ALTER TABLE product_translation CHANGE path_id route_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_translation ADD CONSTRAINT FK_1846DB7034ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1846DB7034ECB4E6 ON product_translation (route_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category_translation DROP FOREIGN KEY FK_3F2070434ECB4E6');
        $this->addSql('DROP INDEX UNIQ_3F2070434ECB4E6 ON category_translation');
        $this->addSql('ALTER TABLE category_translation DROP route_id');
        $this->addSql('ALTER TABLE page_translation DROP FOREIGN KEY FK_A3D51B1D34ECB4E6');
        $this->addSql('DROP INDEX UNIQ_A3D51B1D34ECB4E6 ON page_translation');
        $this->addSql('ALTER TABLE page_translation DROP route_id');
        $this->addSql('ALTER TABLE producer_translation DROP FOREIGN KEY FK_689F236B34ECB4E6');
        $this->addSql('DROP INDEX UNIQ_689F236B34ECB4E6 ON producer_translation');
        $this->addSql('ALTER TABLE producer_translation DROP route_id');
        $this->addSql('ALTER TABLE product_translation DROP FOREIGN KEY FK_1846DB7034ECB4E6');
        $this->addSql('DROP INDEX UNIQ_1846DB7034ECB4E6 ON product_translation');
        $this->addSql('ALTER TABLE product_translation CHANGE route_id path_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_translation ADD CONSTRAINT FK_1846DB70D96C566B FOREIGN KEY (path_id) REFERENCES route (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1846DB70D96C566B ON product_translation (path_id)');
    }
}
