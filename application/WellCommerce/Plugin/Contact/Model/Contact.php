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
 * Class Contact
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Contact extends Model implements TranslatableModelInterface
{

    protected $table = 'contact';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['id'];

    /**
     * Relation with translation table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translation()
    {
        return $this->hasMany('WellCommerce\Core\Model\ContactTranslation');
    }

    /**
     * Mutator for enabled attribute
     *
     * @param $value
     */
    public function setEnabledAttribute($value)
    {
        $this->attributes['enabled'] = (int)$value;
    }

    /**
     * Accessor for enabled attribute
     *
     * @param $value
     *
     * @return int
     */
    public function getEnabledAttribute($value)
    {
        return (int)$value;
    }
}