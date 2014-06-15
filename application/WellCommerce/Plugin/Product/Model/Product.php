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
namespace WellCommerce\Plugin\Product\Model;

use WellCommerce\Core\Component\Model\AbstractModel;
use WellCommerce\Core\Component\Model\TranslatableModelInterface;
use WellCommerce\Core\Helper\Helper;

/**
 * Class Product
 *
 * @package WellCommerce\Plugin\Product\Model
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
        return $this->hasMany('WellCommerce\Plugin\Product\Model\ProductTranslation');
    }

    /**
     * Relation with Shop model through pivot table product_shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shop()
    {
        return $this->belongsToMany('WellCommerce\Plugin\Shop\Model\Shop', 'product_shop', 'product_id', 'shop_id');
    }

    /**
     * Relation with Category model through pivot table product_category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany('WellCommerce\Plugin\Category\Model\Category', 'product_category', 'product_id', 'category_id');
    }

    /**
     * Relation with Deliverer model through pivot table product_deliverer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deliverer()
    {
        return $this->belongsToMany('WellCommerce\Plugin\Deliverer\Model\Deliverer', 'product_deliverer', 'product_id', 'deliverer_id');
    }

    /**
     * Relation with File model through pivot table product_photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function photos()
    {
        return $this->belongsToMany('WellCommerce\Plugin\File\Model\File', 'product_photo', 'product_id', 'file_id');
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