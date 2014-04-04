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
namespace WellCommerce\Plugin\Availability\Model;

use WellCommerce\Core\Component\Model\AbstractModel;
use WellCommerce\Core\Component\Model\TranslatableModelInterface;

/**
 * Class Availability
 *
 * @package WellCommerce\Plugin\Availability\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Availability extends AbstractModel implements TranslatableModelInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'availability';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Indicates if the model should soft delete.
     *
     * @var bool
     */
    protected $softDelete = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id'];

    /**
     * Relation with AvailabilityTranslationModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function translation()
    {
        return $this->hasMany('WellCommerce\Plugin\Availability\Model\AvailabilityTranslation');
    }
}
