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

use WellCommerce\Core\Component\Model\AbstractModel;
use WellCommerce\Core\Component\Model\ModelInterface;
use WellCommerce\Core\Component\Model\TranslatableModelInterface;

/**
 * Class Category
 *
 * @package WellCommerce\Plugin\Category\Model
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class Category extends AbstractModel implements ModelInterface, TranslatableModelInterface
{
    protected $table = 'category';
    protected $fillable = ['id'];

    /**
     * Returns category query with relations
     *
     * @param $query
     * @param $languageId
     *
     * @return mixed
     */
    private function getCategoryQuery($query, $language)
    {
        $query->with([
            'translation' =>
                function ($query) use ($language) {
                    $query->where('language_id', '=', $language);
                }
        ]);

        $query->with([
            'shop',
            'photo'
        ]);

        return $query;
    }

    /**
     * Scope which loads category model by its slug
     *
     * @param $query
     * @param $slug
     * @param $languageId
     *
     * @return mixed
     */
    public function scopeLoadBySlug($query, $slug, $language)
    {
        $this->getCategoryQuery($query, $language);

        return $query->whereHas('translation', function ($q) use ($slug, $language) {
            $q->where('slug', '=', $slug);
            $q->where('language_id', '=', $language);
        });
    }

    /**
     * Relation with Shop model through pivot table category_shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shop()
    {
        return $this->belongsToMany('WellCommerce\Plugin\Shop\Model\Shop', 'category_shop', 'category_id', 'shop_id');
    }

    /**
     * Relation with CategoryTranslation model
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function translations()
    {
        return $this->hasMany('WellCommerce\Plugin\Category\Model\CategoryTranslation');
    }

    /**
     * Relation with CategoryTranslation model
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function translation()
    {
        return $this->hasOne('WellCommerce\Plugin\Category\Model\CategoryTranslation');
    }

    /**
     * Relation with File model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo('WellCommerce\Plugin\File\Model\File');
    }

    /**
     * Scope for getting all parent categories
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for getting all child categories for given parent category
     *
     * @param $query
     * @param $parent
     *
     * @return mixed
     */
    public function scopeChildren($query, $parent)
    {
        return $query->where('parent_id', '=', $parent);
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

    /**
     * Mutator for parent_id attribute
     *
     * @param $value
     */
    public function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] = ((int)$value == 0) ? null : $value;
    }

    /**
     * Mutator for hierarchy attribute
     *
     * @param $value
     */
    public function setHierarchyAttribute($value)
    {
        $this->attributes['hierarchy'] = (int)$value;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}