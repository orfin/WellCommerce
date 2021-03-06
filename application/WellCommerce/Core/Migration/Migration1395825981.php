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
 * Migration1395825981
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1395825981 extends Migration implements MigrationInterface
{
    public function up()
    {
        if (!$this->getDb()->schema()->hasTable('migration')) {
            $this->getDb()->schema()->create('migration', function ($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->timestamps();
            });
        }

        if (!$this->getDb()->schema()->hasTable('layout_page')) {
            $this->getDb()->schema()->create('layout_page', function ($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->string('folder', 255);
                $table->timestamps();
            });
        }
    }

    public function down()
    {

    }
}