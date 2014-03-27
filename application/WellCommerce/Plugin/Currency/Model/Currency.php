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
namespace WellCommerce\Plugin\Currency\Model;

use WellCommerce\Core\Model;

/**
 * Class Currency
 *
 * @package WellCommerce\Plugin\Currency\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Currency extends Model
{
    protected $table = 'currency';
    public $timestamps = true;
    protected $softDelete = false;
    protected $fillable = array('id');

}