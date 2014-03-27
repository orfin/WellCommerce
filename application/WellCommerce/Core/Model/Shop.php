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
 * Class Shop
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Shop extends Model implements TranslatableModelInterface
{

    protected $table = 'shop';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id'];

    public function translation()
    {
        return $this->hasMany('WellCommerce\Core\Model\ShopTranslation');
    }

    public function company()
    {
        return $this->belongsTo('WellCommerce\Core\Model\Company');
    }

    /**
     * Mutator for offline attribute
     *
     * @param $value
     */
    public function setOfflineAttribute($value)
    {
        $this->attributes['offline'] = (int)$value;
    }

    /**
     * Accessor for offline attribute
     *
     * @param $value
     *
     * @return int
     */
    public function getOfflineAttribute($value)
    {
        return (int)$value;
    }
}