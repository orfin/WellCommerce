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
 * Migration1393512866
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1393512866 extends Migration implements MigrationInterface
{

    public function up()
    {
        if (!$this->getDb()->schema()->hasTable('language')) {
            $this->getDb()->schema()->create('language', function ($table) {
                $table->increments('id');
                $table->timestamps();
                $table->string('name', 12)->unique();
                $table->string('translation', 255);
                $table->string('locale', 12);
                $table->integer('currency_id')->unsigned();
                $table->foreign('currency_id')->references('id')->on('currency')->onDelete('SET NULL')->onUpdate('NO ACTION');
            });
        }
    }

    public function down()
    {
        if ($this->getDb()->schema()->hasTable('language')) {
            $this->getDb()->schema()->drop('language');
        }
    }
}