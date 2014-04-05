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
 * Class LayoutBoxSettings
 *
 * @package WellCommerce\Plugin\Layout\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LayoutBoxSettings extends AbstractModel
{

    protected $table = 'layout_box_settings';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id', 'param'];

    /**
     * Mutator for value attribute
     *
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = serialize($value);
    }

    /**
     * Accessor for value attribute
     *
     * @param $value
     *
     * @return int
     */
    public function getValueAttribute($value)
    {
        return unserialize($value);
    }
}