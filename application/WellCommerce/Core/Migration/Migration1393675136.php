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
 * Migration1393675136
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1393675136 extends Migration implements MigrationInterface
{
    public function up()
    {
        /*
         * Create company table
        */
        if (!$this->getDb()->schema()->hasTable('company')) {
            $this->getDb()->schema()->create('company', function ($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->string('short_name', 255);
                $table->string('street', 255);
                $table->string('streetno', 255);
                $table->string('flatno', 12);
                $table->string('postcode', 12);
                $table->string('province', 255);
                $table->string('city', 255);
                $table->string('country', 12);
                $table->timestamps();
            });
        }
    }


    public function down()
    {
        /*
         * Drop company table
        */
        if ($this->getDb()->schema()->hasTable('company')) {
            $this->getDb()->schema()->drop('company');
        }
    }
}