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
 * Class DelivererTranslation
 *
 * @package WellCommerce\Core\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererTranslation extends Model
{

    protected $table = 'deliverer_translation';

    public $timestamps = true;

    protected $softDelete = false;

    protected $fillable = ['deliverer_id', 'language_id', 'name'];

    /**
     * Relation with deliverer table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliverer()
    {
        return $this->belongsTo('WellCommerce\Core\Model\Deliverer');
    }

    /**
     * {@inheritdoc}
     */
    public function language()
    {
        return $this->belongsTo('WellCommerce\Core\Model\Language');
    }

    /**
     * {@inheritdoc}
     */
    public function scopeHasLanguageId($query, $language)
    {
        return $query->whereLanguageId($language)->first();
    }
}