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

namespace WellCommerce\Bundle\CoreBundle\Form\Builder;

use WellCommerce\Bundle\CoreBundle\Form\Conditions;
use WellCommerce\Bundle\CoreBundle\Form\Elements;
use WellCommerce\Bundle\CoreBundle\Form\Filters;
use WellCommerce\Bundle\CoreBundle\Form\Rules;

/**
 * Interface FormBuilderInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormBuilderInterface
{
    /**
     * form.init event name
     */
    const FORM_INIT_EVENT = 'form.init';

    /**
     * Creates the form, triggers init event and then populates form with values
     *
     * @param array $options
     * @param null  $formData
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface
     */
    public function createForm($options, $formData = null);

    /**
     * Returns an element object by its type
     *
     * @param string $type
     * @param array  $options
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface
     */
    public function getElement($type, array $options = []);

    /**
     * Returns a rule object by its type
     *
     * @param string $type
     * @param array  $options
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Rules\RuleInterface
     */
    public function getRule($type, array $options = []);

    /**
     * Returns a filter object by its type
     *
     * @param string $type
     * @param array  $options
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface
     */
    public function getFilter($type, array $options = []);

    /**
     * Returns a dependency object by its type
     *
     * @param string $type
     * @param array  $options
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Dependencies\DependencyInterface
     */
    public function getDependency($type, array $options = []);
}