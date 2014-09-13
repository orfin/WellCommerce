<?php

namespace WellCommerce\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140913230106 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE attribute_group_attribute (attribute_group_id INT NOT NULL, attribute_id INT NOT NULL, INDEX IDX_DEFA010862D643B7 (attribute_group_id), INDEX IDX_DEFA0108B6E62EFA (attribute_id), PRIMARY KEY(attribute_group_id, attribute_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute_group_attribute ADD CONSTRAINT FK_DEFA010862D643B7 FOREIGN KEY (attribute_group_id) REFERENCES attribute_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribute_group_attribute ADD CONSTRAINT FK_DEFA0108B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE attribute_group_attribute');
    }
}
