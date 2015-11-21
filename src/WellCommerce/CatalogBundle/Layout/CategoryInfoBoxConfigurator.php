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

namespace WellCommerce\CatalogBundle\Layout;

use WellCommerce\CoreBundle\Component\Form\Elements\FormInterface;
use WellCommerce\CoreBundle\Component\Form\FormBuilderInterface;
use WellCommerce\LayoutBundle\Configurator\AbstractLayoutBoxConfigurator;
use WellCommerce\LayoutBundle\Configurator\LayoutBoxConfiguratorInterface;

/**
 * Class CategoryInfoBoxConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryInfoBoxConfigurator extends AbstractLayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function addFormFields(FormBuilderInterface $builder, FormInterface $form, $defaults)
    {
        $fieldset = $this->getFieldset($builder, $form);

        $fieldset->addChild($builder->getElement('tip', [
            'tip' => '<p>' . $this->trans('Choose categories which should be not visible in box.') . '</p>'
        ]));
    }
}
