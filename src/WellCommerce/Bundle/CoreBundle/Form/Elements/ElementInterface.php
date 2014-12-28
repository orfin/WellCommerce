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

use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;

/**
 * Interface ElementInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ElementInterface
{
    const INFINITE      = 'inf';
    const TYPE_NUMBER   = 'number';
    const TYPE_STRING   = 'string';
    const TYPE_FUNCTION = 'function';
    const TYPE_ARRAY    = 'array';
    const TYPE_OBJECT   = 'object';
    const TYPE_BOOLEAN  = 'boolean';

//    /**
//     * Configures element attributes
//     *
//     * @param OptionsResolver $resolver
//     *
//     * @return mixed
//     */
//    public function configureAttributes(OptionsResolver $resolver);
//
//    /**
//     * Prepares form element attributes for Javascript rendering
//     *
//     * @return mixed
//     */
//    public function prepareAttributesJs();
//
//    /**
//     * Sets element options
//     *
//     * @param array $options
//     *
//     * @return void
//     */
//    public function setOptions(array $options = []);
//
//    /**
//     * Sets property path for form field
//     *
//     * @return void
//     */
//    public function setPropertyPath();
//
//    /**
//     * Returns field value
//     *
//     * @return mixed
//     */
//    public function getValue();
//
//    /**
//     * Handles submit request
//     *
//     * @return void
//     */
//    public function handleRequest($data);
//
//    /**
//     * Populates the form element with values
//     *
//     * @param mixed $value
//     *
//     * @return void
//     */
//    public function populate($value);
//
//    /**
//     * Sets default data for form element
//     *
//     * @param $data
//     *
//     * @return mixed
//     */
//    public function setDefaults($data);
//
    /**
     * Returns element name
     *
     * @return string
     */
    public function getName();

    /**
     * Adds element to field
     *
     * @param ElementInterface $element
     *
     * @return ElementInterface
     */
    public function addElement(ElementInterface $element);

    /**
     * Adds filter to element
     *
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter);
}