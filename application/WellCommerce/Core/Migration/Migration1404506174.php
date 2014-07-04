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
 * Migration1404506174
 *
 * This class has been auto-generated
 * by the WellCommerce Console migrate:add command
 */
class Migration1404506174 extends AbstractMigration implements MigrationInterface
{
    public function up()
    {
        // create client table
        if (!$this->getDb()->schema()->hasTable('client')) {
            $this->getDb()->schema()->create('client', function ($table) {
                $table->increments('id');
                $table->string('first_name', 255);
                $table->string('last_name', 255);
                $table->string('phone', 255);
                $table->string('email', 255);
                $table->string('password', 255);
                $table->integer('client_group_id')->unsigned();
                $table->integer('shop_id')->unsigned();
                $table->decimal('discount', 15, 2)->default(0);
                $table->boolean('active')->default(true);
                $table->timestamps();
                $table->foreign('client_group_id')->references('id')->on('client_group')->onDelete('CASCADE')->onUpdate('NO ACTION');
                $table->foreign('shop_id')->references('id')->on('shop')->onDelete('CASCADE')->onUpdate('NO ACTION');
                $table->unique(['email', 'shop_id']);
            });
        }

        // create client_address  table
        if (!$this->getDb()->schema()->hasTable('client_address')) {
            $this->getDb()->schema()->create('client_address', function ($table) {
                $table->increments('id');
                $table->integer('client_id')->unsigned();
                $table->integer('type')->unsigned()->default(1);
                $table->string('first_name', 255);
                $table->string('last_name', 255);
                $table->string('phone', 255);
                $table->string('street', 255);
                $table->string('street_no', 255);
                $table->string('flat_no', 255);;
                $table->string('post_code', 255);
                $table->string('city', 255);
                $table->string('company_name', 255);
                $table->string('vat_id', 255);
                $table->string('country', 12);
                $table->timestamps();
                $table->foreign('client_id')->references('id')->on('client')->onDelete('CASCADE')->onUpdate('NO ACTION');
            });
        }
    }

    public function down()
    {

    }
}