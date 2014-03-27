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
 * Class AvailabilityTranslation
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityTranslation extends Model
{

    /**
     * @var string
     */
    protected $table = 'availability_translation';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array
     */
    protected $fillable = ['availability_id', 'language_id'];

    /**
     * @var array
     */
    protected $translatable
        = [
            'name',
            'description'
        ];

    /**
     * Relation with availability table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function availability()
    {
        return $this->belongsTo('WellCommerce\Core\Model\Availability');
    }

    /**
     * Relation with language table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo('WellCommerce\Core\Model\Language');
    }
}
