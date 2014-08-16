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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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

    /**
     * Configures element attributes
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return void
     */
    public function configureAttributes(OptionsResolverInterface $resolver);

    /**
     * Prepares form element attributes for Javascript rendering
     *
     * @return mixed
     */
    public function prepareAttributesJs();

    /**
     * Sets element options
     *
     * @param array $options
     *
     * @return void
     */
    public function setOptions(array $options = []);

    /**
     * Sets property path for form field
     *
     * @return void
     */
    public function setPropertyPath();

    /**
     * Returns field value
     */
    public function getValue();

    /**
     * Handles submit request
     */
    public function handleRequest($data);
} 