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
namespace WellCommerce\Plugin\Language\Model;

use WellCommerce\Core\Model;

/**
 * Class Language
 *
 * @package WellCommerce\Plugin\Language\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class Language extends Model
{

    public $timestamps = true;
    protected $table = 'language';
    protected $softDelete = false;
    protected $fillable = array('id');

    public function currency()
    {
        return $this->belongsTo('WellCommerce\Core\Model\Currency');
    }
}