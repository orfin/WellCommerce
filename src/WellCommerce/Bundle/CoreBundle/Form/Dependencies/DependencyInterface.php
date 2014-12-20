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

namespace WellCommerce\Bundle\CoreBundle\Form\Dependencies;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Interface DependencyInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Dependencies
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DependencyInterface
{
    /**
     * Configures dependency options
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolverInterface $resolver);

    /**
     * Sets dependency options
     *
     * @param array $options
     *
     * @return mixed
     */
    public function setOptions(array $options = []);

    /**
     * Returns dependency type used in javascript calls
     *
     * @return mixed
     */
    public function getJavascriptType();

    /**
     * Returns javascript part for dependency
     *
     * @return string
     */
    public function renderJs();
}