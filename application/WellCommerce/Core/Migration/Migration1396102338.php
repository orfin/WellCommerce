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
 * Migration1396102338
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1396102338 extends Migration implements MigrationInterface
{
    public function up()
    {
        if (!$this->getDb()->schema()->hasTable('layout_box')) {
            $this->getDb()->schema()->create('layout_box', function ($table) {
                $table->increments('id');
                $table->string('identifier', 255);
                $table->string('controller', 255);
                $table->timestamps();
                $table->unique(Array('identifier'));
            });
        }

        if (!$this->getDb()->schema()->hasTable('layout_box_translation')) {
            $this->getDb()->schema()->create('layout_box_translation', function ($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->text('content');
                $table->integer('layout_box_id')->unsigned();
                $table->integer('language_id')->unsigned();
                $table->timestamps();
                $table->foreign('layout_box_id')->references('id')->on('layout_box')->onDelete('CASCADE')->onUpdate('NO ACTION');
                $table->foreign('language_id')->references('id')->on('language')->onDelete('CASCADE')->onUpdate('NO ACTION');
            });
        }

        if (!$this->getDb()->schema()->hasTable('layout_box_settings')) {
            $this->getDb()->schema()->create('layout_box_settings', function ($table) {
                $table->increments('id');
                $table->string('param', 255);
                $table->binary('value');
                $table->integer('layout_box_id')->unsigned();
                $table->timestamps();
                $table->foreign('layout_box_id')->references('id')->on('layout_box')->onDelete('CASCADE')->onUpdate('NO ACTION');
            });
        }
    }

    public function down()
    {

    }
}