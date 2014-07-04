<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Core\Migration;

use WellCommerce\Core\Migration;

/**
 * Migration1404342909
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1404342909 extends AbstractMigration implements MigrationInterface
{
    public function up()
    {
        if (!$this->getDb()->schema()->hasTable('attribute_group')) {
            $this->getDb()->schema()->create('attribute_group', function ($table) {
                $table->increments('id');
                $table->timestamps();
            });
        }

        if (!$this->getDb()->schema()->hasTable('attribute_group_translation')) {
            $this->getDb()->schema()->create('attribute_group_translation', function ($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->integer('attribute_group_id')->unsigned();
                $table->integer('language_id')->unsigned();
                $table->timestamps();
                $table->foreign('attribute_group_id')->references('id')->on('attribute_group')->onDelete('cascade')->onUpdate('NO ACTION');
                $table->foreign('language_id')->references('id')->on('language')->onDelete('CASCADE')->onUpdate('NO ACTION');
                $table->unique(['name', 'language_id']);
            });
        }

        if (!$this->getDb()->schema()->hasTable('attribute')) {
            $this->getDb()->schema()->create('attribute', function ($table) {
                $table->increments('id');
                $table->timestamps();
            });
        }

        if (!$this->getDb()->schema()->hasTable('attribute_translation')) {
            $this->getDb()->schema()->create('attribute_translation', function ($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->integer('attribute_id')->unsigned();
                $table->integer('language_id')->unsigned();
                $table->timestamps();
                $table->foreign('attribute_id')->references('id')->on('attribute')->onDelete('cascade')->onUpdate('NO ACTION');
                $table->foreign('language_id')->references('id')->on('language')->onDelete('CASCADE')->onUpdate('NO ACTION');
                $table->unique(['name', 'language_id']);
            });
        }

        if (!$this->getDb()->schema()->hasTable('attribute_group_attribute')) {
            $this->getDb()->schema()->create('attribute_group_attribute', function ($table) {
                $table->increments('id');
                $table->integer('attribute_id')->unsigned();
                $table->integer('attribute_group_id')->unsigned();
                $table->timestamps();
                $table->foreign('attribute_id')->references('id')->on('attribute')->onDelete('cascade')->onUpdate('NO ACTION');
                $table->foreign('attribute_group_id')->references('id')->on('attribute_group')->onDelete('cascade')->onUpdate('NO ACTION');
                $table->unique(['attribute_id', 'attribute_group_id']);
            });
        }

        if (!$this->getDb()->schema()->hasTable('attribute_value')) {
            $this->getDb()->schema()->create('attribute_value', function ($table) {
                $table->increments('id');
                $table->timestamps();
            });
        }

        if (!$this->getDb()->schema()->hasTable('attribute_value_translation')) {
            $this->getDb()->schema()->create('attribute_value_translation', function ($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->integer('attribute_value_id')->unsigned();
                $table->integer('language_id')->unsigned();
                $table->timestamps();
                $table->foreign('attribute_value_id')->references('id')->on('attribute_value')->onDelete('cascade')->onUpdate('NO ACTION');
                $table->foreign('language_id')->references('id')->on('language')->onDelete('CASCADE')->onUpdate('NO ACTION');
                $table->unique(['name', 'language_id']);
            });
        }

        if (!$this->getDb()->schema()->hasTable('attribute_attribute_value')) {
            $this->getDb()->schema()->create('attribute_attribute_value', function ($table) {
                $table->increments('id');
                $table->integer('attribute_id')->unsigned();
                $table->integer('attribute_value_id')->unsigned();
                $table->timestamps();
                $table->foreign('attribute_id')->references('id')->on('attribute')->onDelete('cascade')->onUpdate('NO ACTION');
                $table->foreign('attribute_value_id')->references('id')->on('attribute_value')->onDelete('cascade')->onUpdate('NO ACTION');
                $table->unique(['attribute_id', 'attribute_value_id']);
            });
        }
    }

    public function down()
    {

    }
}