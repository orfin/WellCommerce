<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150315131825 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category_shop (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, shop_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_27F136E512469DE2 (category_id), UNIQUE INDEX UNIQ_27F136E54D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_shop ADD CONSTRAINT FK_27F136E512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category_shop ADD CONSTRAINT FK_27F136E54D16C4DD FOREIGN KEY (shop_id) REFERENCES Shop (id)');
        $this->addSql('DROP TABLE shop_category');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shop_category (category_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_DDF4E3574D16C4DD (shop_id), INDEX IDX_DDF4E35712469DE2 (category_id), PRIMARY KEY(category_id, shop_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop_category ADD CONSTRAINT FK_DDF4E35712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_category ADD CONSTRAINT FK_DDF4E3574D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE category_shop');
    }
}
