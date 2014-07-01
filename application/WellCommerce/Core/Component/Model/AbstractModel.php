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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Model\Collection\CustomCollection;
use Symfony\Component\Validator\Validation;
use WellCommerce\Core\Helper\TableInfo;

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
     * Wraps every delete operation into transaction
     *
     * @return bool|null|void
     */
    public function delete()
    {
        $this->getConnection()->transaction(function () {
            parent::delete();
        });
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
        $this->validate();

        parent::update($attributes);
    }

    /**
     * Scope that filters query using given parameters
     *
     * @param $query
     * @param $relation
     * @param $column
     * @param $value
     *
     * @return mixed
     */
    public function scopeFilterBy($query, $relation, $column, $value)
    {
        return $query->whereHas($relation, function ($q) use ($column, $value) {
            $q->where($column, '=', $value);
        });
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

        $violations = $validator->validate($this);

        if (count($violations) > 0) {
            $exceptionMessage = '';
            foreach ($violations as $violation) {
                $exceptionMessage .= $violation->getMessage();
            }
            throw new ValidatorException($exceptionMessage);
        }
    }

    /**
     * Prepares passed translation data for use in update method
     *
     * @param array $data
     * @param       $language
     */
    public function getTranslation(array $data, $language)
    {
        $translation = [];
        $attributes  = $this->getAccessibleAttributes();

        foreach ($data as $attribute => $values) {
            if (in_array($attribute, $attributes) && isset($values[$language])) {
                $translation[$attribute] = $values[$language];
            }
        }

        return $translation;
    }

    /**
     * Returns all accessible attributes for model
     * using information fetched from db schema
     *
     * @return mixed
     */
    private function getAccessibleAttributes()
    {
        return TableInfo::getColumns($this->table);
    }

    /**
     * Sets model attributes
     *
     * @param array $attributes
     */
    public function set(array $attributes = [])
    {
        $possibleAttributes = $this->getAccessibleAttributes();

        foreach ($attributes as $key => $value) {
            if (in_array($key, $possibleAttributes)) {
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
    public function newCollection(array $models = [])
    {
        return new CustomCollection($models);
    }

}