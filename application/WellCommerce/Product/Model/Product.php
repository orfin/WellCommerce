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
namespace WellCommerce\Product\Model;

use WellCommerce\Core\Component\Model\AbstractModel;
use WellCommerce\Core\Component\Model\TranslatableModelInterface;
use WellCommerce\Core\Helper\Helper;

/**
 * Class Product
 *
 * @package WellCommerce\Product\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Product extends AbstractModel implements TranslatableModelInterface
{
    protected $table = 'product';
    protected $fillable = ['id'];

    /**
     * {@inheritdoc}
     */
    public function translation()
    {
        return $this->hasOne('WellCommerce\Product\Model\ProductTranslation');
    }

    /**
     * {@inheritdoc}
     */
    public function translations()
    {
        return $this->hasMany('WellCommerce\Product\Model\ProductTranslation');
    }

    /**
     * Returns product query with relations
     *
     * @param $query
     * @param $languageId
     *
     * @return mixed
     */
    private function getProductQuery($query, $language)
    {
        $query->with([
            'translation'          =>
                function ($query) use ($language) {
                    $query->where('language_id', '=', $language);
                },
            'producer.translation' =>
                function ($query) use ($language) {
                    $query->where('language_id', '=', $language);
                },
        ]);

        $query->with([
            'shop',
            'producer',
            'deliverer',
            'photos',
            'category'
        ]);

        return $query;
    }

    /**
     * Scope which loads product model by its slug
     *
     * @param $query
     * @param $slug
     * @param $languageId
     *
     * @return mixed
     */
    public function scopeLoadBySlug($query, $slug, $language)
    {
        $this->getProductQuery($query, $language);

        return $query->whereHas('translation', function ($q) use ($slug, $language) {
            $q->where('slug', '=', $slug);
            $q->where('language_id', '=', $language);
        });
    }

    /**
     * Scope which loads product by its id
     *
     * @param $query
     * @param $id
     * @param $languageId
     *
     * @return mixed
     */
    public function scopeLoadById($query, $id, $languageId)
    {
        $this->getProductQuery($query, $languageId);

        return $query->whereHas('translation', function ($q) use ($id, $languageId) {
            $q->where('product_id', '=', $id);
            $q->where('language_id', '=', $languageId);
        });
    }

    /**
     * Relation with Shop model through pivot table product_shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shop()
    {
        return $this->belongsToMany('WellCommerce\Shop\Model\Shop', 'product_shop', 'product_id', 'shop_id');
    }

    /**
     * Relation with Category model through pivot table product_category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany('WellCommerce\Category\Model\Category', 'product_category', 'product_id', 'category_id');
    }

    /**
     * Relation with Deliverer model through pivot table product_deliverer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deliverer()
    {
        return $this->belongsToMany('WellCommerce\Deliverer\Model\Deliverer', 'product_deliverer', 'product_id', 'deliverer_id');
    }

    /**
     * Relation with File model through pivot table product_photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function photos()
    {
        return $this->belongsToMany('WellCommerce\File\Model\File', 'product_photo', 'product_id', 'file_id');
    }

    /**
     * Relation with Producer model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function producer()
    {
        return $this->hasOne('WellCommerce\Producer\Model\Producer', 'id', 'producer_id');
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
     * Mutator for track_stock attribute
     *
     * @param $value
     */
    public function setTrackStockAttribute($value)
    {
        $this->attributes['track_stock'] = (int)$value;
    }

    /**
     * Accessor for track_stock attribute
     *
     * @param $value
     *
     * @return int
     */
    public function getTrackStockAttribute($value)
    {
        return (int)$value;
    }

    /**
     * Mutator for tax_id attribute
     *
     * @param $value
     */
    public function setTaxIdAttribute($value)
    {
        $this->attributes['tax_id'] = ($value == 0) ? null : (int)$value;
    }

    /**
     * Accessor for tax_id attribute
     *
     * @param $value
     *
     * @return int
     */
    public function getTaxIdAttribute($value)
    {
        return (int)$value;
    }

    /**
     * Mutator for weight attribute
     *
     * @param $value
     */
    public function setWeightAttribute($value)
    {
        $this->attributes['weight'] = Helper::changeCommaToDot($value);
    }

    /**
     * Mutator for sell_price attribute
     *
     * @param $value
     */
    public function setSellPriceAttribute($value)
    {
        $this->attributes['sell_price'] = Helper::changeCommaToDot($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationXmlMapping()
    {
        return __DIR__ . '/../Resources/config/validation.xml';
    }
}