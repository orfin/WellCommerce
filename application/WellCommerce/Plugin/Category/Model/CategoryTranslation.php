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
namespace WellCommerce\Plugin\Category\Model;

use WellCommerce\Core\Model;

/**
 * Class CategoryTranslation
 *
 * @package WellCommerce\Plugin\Category\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class CategoryTranslation extends Model
{

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'category_translation';

    /**
     * Use timestamp columns
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Use soft deletes
     *
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array
     */
    protected $fillable = ['category_id', 'language_id'];

    /**
     * All translatable columns in category_translation table
     *
     * @var array
     */
    protected $translatable
        = [
            'name',
            'slug',
            'short_description',
            'description',
            'meta_title',
            'meta_keywords',
            'meta_description'
        ];

    /**
     * Relation with Category model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('WellCommerce\Plugin\Category\Model\Category');
    }

    /**
     * Relation with Language model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo('WellCommerce\Core\Model\Language');
    }
}