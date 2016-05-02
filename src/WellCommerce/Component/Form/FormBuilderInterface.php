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

namespace WellCommerce\Component\Form;

use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Filters\FilterInterface;

/**
 * Interface FormBuilderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormBuilderInterface
{
    /**
     * Creates the form, triggers init event and then populates form with values
     *
     * @param array $options
     * @param null  $formData
     *
     * @return FormInterface
     */
    public function createForm(array $options, $formData = null) : FormInterface;
    
    /**
     * Returns an element object by its type
     *
     * @param string $type
     * @param array  $options
     *
     * @return ElementInterface
     */
    public function getElement(string $type, array $options = []) : ElementInterface;
    
    /**
     * Returns a filter object by its type
     *
     * @param string $type
     * @param array  $options
     *
     * @return FilterInterface
     */
    public function getFilter(string $type, array $options = []) : FilterInterface;
    
    /**
     * Returns a dependency object by its type
     *
     * @param string $type
     * @param array  $options
     *
     * @return DependencyInterface
     */
    public function getDependency(string $type, array $options = []) : DependencyInterface;
}
