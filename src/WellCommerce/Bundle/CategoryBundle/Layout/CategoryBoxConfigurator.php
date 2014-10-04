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

namespace WellCommerce\Bundle\CategoryBundle\Layout;

use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\LayoutBundle\Configurator\LayoutBoxConfiguratorInterface;
use WellCommerce\Bundle\LayoutBundle\Layout\Configurator\AbstractLayoutBoxConfigurator;

/**
 * Class CategoryBoxConfigurator
 *
 * @package WellCommerce\Bundle\CategoryBundle\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryBoxConfigurator extends AbstractLayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function addFormFields(FormBuilderInterface $builder)
    {
        $form = $builder->getForm();
    }
} 