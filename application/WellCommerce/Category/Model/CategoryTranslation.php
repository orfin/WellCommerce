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
namespace WellCommerce\Category\Model;

use WellCommerce\Core\Model\AbstractModel;
use WellCommerce\Core\Helper\Helper;

/**
 * Class CategoryTranslation
 *
 * @package WellCommerce\Category\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class CategoryTranslation extends AbstractModel
{
    protected $table = 'category_translation';
    protected $fillable = ['category_id', 'language_id'];

    /**
     * Relation with Category model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(__NAMESPACE__ . '\Category');
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

    /**
     * Mutator for enabled attribute
     *
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Helper::makeSlug($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}