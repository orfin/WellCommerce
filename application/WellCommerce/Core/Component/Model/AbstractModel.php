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
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Model\Collection\CustomCollection;
use Symfony\Component\Validator\Validation;

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
    public $timestamps = true;

    protected $softDelete = false;

    /**
     * Translatable attributes in model
     *
     * @var array
     */
    protected $translatable = [];

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

    public function getTranslation(array $data, $language)
    {
        $translation = [];

        foreach ($data as $attribute => $values) {
            if ($this->isTranslatableAttribute($attribute)) {
                $translation[$attribute] = $values[$language];
            }
        }

        return $translation;
    }

    /**
     * Sets translatable attributes in model
     *
     * @param array $data
     * @param       $language
     */
    public function setTranslationData(array $data, $languageId)
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
     * @throws \Symfony\Component\Validator\Exception\ValidatorException
     */
    public function update(array $attributes = [])
    {
        $this->set($attributes);

        $violations = $this->validate($attributes);

        if (count($violations) > 0) {
            throw new ValidatorException((string)$violations);
        }

        if (!$this->exists) {
            return $this->newQuery()->update($attributes);
        }

        return $this->set($attributes)->save();
    }

    /**
     * Validates model attributes
     *
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function validate()
    {
        $validatorBuilder = Validation::createValidatorBuilder();
        $validatorBuilder->addXmlMapping($this->getValidationXmlMapping());
        $validator = $validatorBuilder->getValidator();

        return $validator->validate($this);
    }

    /**
     * Sets model attributes
     *
     * @param array $attributes
     */
    public function set(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, array_merge($this->attributesToArray(), array_flip($this->translatable)))) {
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