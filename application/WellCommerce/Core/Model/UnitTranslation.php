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
namespace WellCommerce\Core\Model;

use WellCommerce\Core\Model;

/**
 * Class UnitTranslation
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitTranslation extends Model
{

    protected $table = 'unit_translation';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['unit_id', 'language_id'];

    protected $translatable
        = [
            'name',
        ];

    public function unit()
    {
        return $this->belongsTo('WellCommerce\Core\Model\Unit');
    }

    public function language()
    {
        return $this->belongsTo('WellCommerce\Core\Model\Language');
    }
}