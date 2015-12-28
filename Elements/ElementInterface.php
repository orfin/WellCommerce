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

namespace WellCommerce\Component\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Filters\FilterInterface;

/**
 * Interface ElementInterface
 *
 * @package WellCommerce\Component\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ElementInterface
{
    const INFINITE = 99999;

    /**
     * @param array $options
     */
    public function setOptions(array $options = []);

    /**
     * Configures element attributes
     *
     * @param OptionsResolver $resolver
     *
     * @return mixed
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * Returns element name. Shorthand for getOption('name')
     *
     * @return string
     */
    public function getName();

    /**
     * Returns element name. Shorthand for getOption('label')
     *
     * @return string
     */
    public function getLabel();

    /**
     * Returns element option
     *
     * @return mixed
     */
    public function getOption($option);

    /**
     * Checks whether element has an option
     *
     * @param $option
     *
     * @return bool
     */
    public function hasOption($option);

    /**
     * Returns element options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Checks whether given element has data transformer
     *
     * @return bool
     */
    public function hasTransformer();

    /**
     * Returns data transformer for element
     *
     * @return \WellCommerce\Component\Form\DataTransformer\DataTransformerInterface
     */
    public function getTransformer();

    /**
     * Adds new child to container
     *
     * @param ElementInterface $element
     *
     * @return ElementInterface
     */
    public function addChild(ElementInterface $element);

    /**
     * Returns children collection
     *
     * @return ElementCollection
     */
    public function getChildren();

    /**
     * Adds filter to element
     *
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter);

    /**
     * Prepares attributes collection
     *
     * @param AttributeCollection $collection
     */
    public function prepareAttributesCollection(AttributeCollection $collection);

    /**
     * Checks whether element has property_path option
     *
     * @return bool
     */
    public function hasPropertyPath();

    /**
     * Returns property path
     *
     * @param bool $indexNotation
     *
     * @return null|string|\Symfony\Component\PropertyAccess\PropertyPath
     */
    public function getPropertyPath($indexNotation = false);

    /**
     * Sets value for field
     *
     * @param mixed $value
     */
    public function setValue($value);

    /**
     * Returns elements value
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Returns default value for element if set
     *
     * @return mixed
     */
    public function getDefaultValue();

    /**
     * Sets error on element
     *
     * @param mixed $error
     */
    public function setError($error);

    /**
     * Returns elements error
     *
     * @return string
     */
    public function getError();
}
