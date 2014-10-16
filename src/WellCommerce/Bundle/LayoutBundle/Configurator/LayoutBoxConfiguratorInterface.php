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

namespace WellCommerce\Bundle\LayoutBundle\Configurator;

use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;

/**
 * Interface LayoutBoxConfiguratorInterface
 *
 * @package WellCommerce\Bundle\LayoutBundle\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxConfiguratorInterface
{
    /**
     * Returns configurator type
     *
     * @return mixed
     */
    public function getType();

    /**
     * Adds form fields required to configure the layout box
     *
     * @param FormBuilderInterface $builder
     * @param                      $resource
     *
     * @return mixed
     */
    public function addFormFields(FormBuilderInterface $builder, $resource);

    /**
     * Returns box controller service name
     *
     * @return string
     */
    public function getControllerService();
} 