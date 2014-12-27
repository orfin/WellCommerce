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

namespace WellCommerce\Bundle\CoreBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface FormConfigurationInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormConfigurationInterface
{
    const TABS_VERTICAL   = 0;
    const TABS_HORIZONTAL = 1;
    const FORM_METHOD     = 'POST';

    /**
     * Configures form options
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * Returns form action
     *
     * @return string
     */
    public function getAction();

    /**
     * Returns form class
     *
     * @return string
     */
    public function getClass();

    /**
     * Returns form method
     *
     * @return mixed
     */
    public function getMethod();

    /**
     * Returns tabs direction
     *
     * 0 - horizontal
     * 1 - vertical
     *
     * @return int
     */
    public function getTabs();

    /**
     * Returns form name
     *
     * @return string
     */
    public function getName();
} 