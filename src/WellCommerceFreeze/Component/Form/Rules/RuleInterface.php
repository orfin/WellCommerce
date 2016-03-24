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

namespace WellCommerce\Component\Form\Rules;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface RuleInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RuleInterface
{
    /**
     * Configures rule options
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * Sets rule options
     *
     * @param array $options
     */
    public function setOptions(array $options = []);

    /**
     * Returns rule type used in javascript calls
     *
     * @return string
     */
    public function getJavascriptType();

    /**
     * Returns javascript part for rule
     *
     * @return string
     */
    public function renderJs();
}
