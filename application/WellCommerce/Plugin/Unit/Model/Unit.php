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
namespace WellCommerce\Plugin\Unit\Model;

use WellCommerce\Core\Model;

/**
 * Class Unit
 *
 * @package WellCommerce\Plugin\Unit\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Unit extends Model implements Model\TranslatableModelInterface
{

    protected $table = 'unit';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id'];

    public function translation()
    {
        return $this->hasMany('WellCommerce\Plugin\Unit\Model\UnitTranslation');
    }
}