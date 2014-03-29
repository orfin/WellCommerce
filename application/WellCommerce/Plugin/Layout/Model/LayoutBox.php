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
namespace WellCommerce\Plugin\Layout\Model;

use WellCommerce\Core\Model;

/**
 * Class LayoutBox
 *
 * @package WellCommerce\Plugin\LayoutBox\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LayoutBox extends Model
{

    protected $table = 'layout_box';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id'];

    public function settings()
    {
        return $this->hasMany('WellCommerce\Plugin\Layout\Model\LayoutBoxSettings');
    }
}