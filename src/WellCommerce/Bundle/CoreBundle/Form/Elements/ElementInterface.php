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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;

/**
 * Interface ElementInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ElementInterface
{
    /**
     * Configures element attributes
     *
     * @param OptionsResolver $resolver
     *
     * @return mixed
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * Returns element name
     *
     * @return string
     */
    public function getName();

    /**
     * Returns element option
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException If the option was not found
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
     * Checks whether given element has data transformer
     *
     * @return bool
     */
    public function hasTransformer();

    /**
     * Returns data transformer for element
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DataTransformerInterface
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
     * Prepares attributes for formatter
     *
     * @return array
     */
    public function prepareAttributes();

    /**
     * Checks whether element has property_path option
     *
     * @return bool
     */
    public function hasPropertyPath();

    /**
     * Returns elements property path
     *
     * @return null|\Symfony\Component\PropertyAccess\PropertyPath
     */
    public function getPropertyPath();

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
}