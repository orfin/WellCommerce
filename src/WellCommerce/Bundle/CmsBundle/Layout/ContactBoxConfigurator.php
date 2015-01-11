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

namespace WellCommerce\Bundle\CmsBundle\Layout;

use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\LayoutBundle\Configurator\AbstractLayoutBoxConfigurator;
use WellCommerce\Bundle\LayoutBundle\Configurator\LayoutBoxConfiguratorInterface;

/**
 * Class ContactBoxConfigurator
 *
 * @package WellCommerce\Bundle\CmsBundle\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactBoxConfigurator extends AbstractLayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function addFormFields(FormBuilderInterface $builder, $defaults)
    {
        $fieldset = $this->getFieldset($builder);

        $fieldset->addChild($builder->getElement('tip', [
            'tip' => '<p>'.$this->trans('contact.box.help').'</p>'
        ]));
    }
}
