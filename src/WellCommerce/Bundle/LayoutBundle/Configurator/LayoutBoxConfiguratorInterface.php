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

use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Interface LayoutBoxConfiguratorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxConfiguratorInterface
{
    /**
     * Returns configurator type
     *
     * @return string
     */
    public function getType() : string;

    /**
     * Adds form fields required to configure the layout box
     *
     * @param FormBuilderInterface $builder
     * @param FormInterface        $form
     * @param object               $resource
     *
     * @return mixed
     */
    public function addFormFields(FormBuilderInterface $builder, FormInterface $form, $resource);

    /**
     * Returns box controller service name
     *
     * @return string
     */
    public function getControllerService() : string;
}
