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
 * Migration1393605622
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1393605622 extends Migration
{
    public function up()
    {
        /*
         * Create file table
        */
        if (!$this->getDb()->schema()->hasTable('file')) {
            $this->getDb()->schema()->create('file', function ($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->string('extension', 12);
                $table->string('type', 64);
                $table->integer('width');
                $table->integer('height');
                $table->integer('size');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        /*
         * Drop deliverer_translation table
         */
        if ($this->getDb()->schema()->hasTable('file')) {
            $this->getDb()->schema()->drop('file');
        }
    }
}