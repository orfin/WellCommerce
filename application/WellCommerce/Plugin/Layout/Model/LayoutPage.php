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

use WellCommerce\Core\Component\Model\AbstractModel;

/**
 * Class LayoutPage
 *
 * @package WellCommerce\Plugin\Layout\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LayoutPage extends AbstractModel
{

    protected $table = 'layout_page';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id','name'];

    public function column()
    {
        return $this->hasMany('WellCommerce\Plugin\Layout\Model\LayoutPageColumn');
    }
}