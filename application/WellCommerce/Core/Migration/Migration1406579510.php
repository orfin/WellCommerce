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
 * Migration1406579510
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1406579510 extends AbstractMigration implements MigrationInterface
{
    public function up()
    {
        if (!$this->getDb()->schema()->hasTable('profiler_data')) {
            $this->getDb()->schema()->create('profiler_data', function ($table) {
                $table->increments('id');
                $table->string('token', 255);
                $table->string('parent',255);
                $table->binary('data');
                $table->string('ip', 24);
                $table->string('method', 255);
                $table->string('url', 255);
                $table->dateTime('time');
                $table->timestamps();
            });
        }
    }

    public function down()
    {

    }
}