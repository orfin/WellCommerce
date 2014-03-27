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
 * Class Company
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Company extends Model
{

    protected $table = 'company';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id'];

    /**
     * Relation with
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shop()
    {
        return $this->hasMany('WellCommerce\Core\Model\Shop');
    }
}