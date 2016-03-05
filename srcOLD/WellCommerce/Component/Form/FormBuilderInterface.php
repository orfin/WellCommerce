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
     * @return \WellCommerce\Component\Form\Elements\FormInterface
     */
    public function createForm($options, $formData = null);

    /**
     * Returns an element object by its type
     *
     * @param string $type
     * @param array  $options
     *
     * @return \WellCommerce\Component\Form\Elements\ElementInterface
     */
    public function getElement($type, array $options = []);

    /**
     * Returns a filter object by its type
     *
     * @param string $type
     * @param array  $options
     *
     * @return \WellCommerce\Component\Form\Filters\FilterInterface
     */
    public function getFilter($type, array $options = []);

    /**
     * Returns a dependency object by its type
     *
     * @param string $type
     * @param array  $options
     *
     * @return \WellCommerce\Component\Form\Dependencies\DependencyInterface
     */
    public function getDependency($type, array $options = []);
}
