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
namespace WellCommerce\Core\Component\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use WellCommerce\Core\Component\Model\Collection\CustomCollection;

/**
 * Class AbstractModel
 *
 * Extends base Eloquent model and provides additional methods
 *
 * @package WellCommerce\Core\Component\Model
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractModel extends BaseModel
{
    /**
     * Translatable attributes in model
     *
     * @var array
     */
    protected $translatable = [];

    /**
     * Boots Illuminate\Database\Eloquent\Model
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
    }

    /**
     * Returns all model translatable attributes
     *
     * @return array
     */
    protected function getTranslatableAttributes()
    {
        return $this->translatable;
    }

    /**
     * Adds new translatable attribute
     *
     * @param $attribute
     */
    public function addTranslatableAttribute($attribute)
    {
        $this->translatable[] = $attribute;
    }

    /**
     * Checks if attribute is translatable
     *
     * @param $key
     *
     * @return bool
     */
    protected function isTranslatableAttribute($key)
    {
        return array_key_exists($key, array_flip($this->translatable));
    }

    /**
     * Shortcut to get PropertyAccessor
     *
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }

    /**
     * Sets translatable attributes in model
     *
     * @param array $data
     * @param       $language
     */
    public function setTranslationData(array $data)
    {
        $accessor = $this->getPropertyAccessor();

        foreach ($data as $attribute => $value) {
            if ($this->isTranslatableAttribute($attribute)) {
                $accessor->setValue($this, $attribute, $value);
            }
        }
    }

    /**
     * Returns translation data
     *
     * @return array
     * @throws \LogicException
     */
    public function getTranslationData()
    {
        if (!$this instanceof TranslatableModelInterface) {
            throw new \LogicException('Model must implement TranslatableModelInterface to get translations from it.');
        }

        $collection   = $this->translation;
        $languageData = [];

        foreach ($collection as $item) {
            foreach ($item->translatable as $attribute) {
                $languageData[$item->language_id][$attribute] = $item->$attribute;
            }
        }

        return $languageData;
    }

    /**
     * Updates model with new attributes
     *
     * @param array $attributes
     *
     * @return int|mixed
     */
    public function update(array $attributes = [])
    {
        if (!$this->exists) {
            return $this->newQuery()->update($attributes);
        }

        return $this->set($attributes)->save();
    }

    /**
     * Sets model attributes
     *
     * @param array $attributes
     */
    public function set(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $this->attributesToArray())) {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }

    /**
     * Synchronizes data in BelongsToMany relation
     *
     * @param BelongsToMany $relation
     * @param array|string  $values
     */
    public function sync(BelongsToMany $relation, $values)
    {
        if (!empty($values)) {
            $relation->sync($values);
        } else {
            $relation->detach();
        }
    }

    /**
     * Override default collection model
     *
     * @param array $models
     *
     * @return \Illuminate\Database\Eloquent\Collection|CustomCollection
     */
    public function newCollection(array $models = Array())
    {
        return new CustomCollection($models);
    }

}