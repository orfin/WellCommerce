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

namespace WellCommerce\Component\Form\Dependencies;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface DependencyInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DependencyInterface
{
    /**
     * Configures dependency options
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver);

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
