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
 * Class Language
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Language extends Model
{

    protected $table = 'language';
    public $timestamps = true;
    protected $softDelete = false;
    protected $fillable = array('id');

    public function currency()
    {
        return $this->belongsTo('WellCommerce\Core\Model\Currency');
    }
}