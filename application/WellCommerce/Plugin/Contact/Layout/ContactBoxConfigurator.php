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

namespace WellCommerce\Plugin\Contact\Layout;

use WellCommerce\Core\Form;
use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\LayoutBoxConfiguratorInterface;

/**
 * Class ContactBoxConfigurator
 *
 * @package WellCommerce\Plugin\Contact\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Contact';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'wellcommerce.box.contact';
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailableForLayoutPage($layoutPage)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields(Form\Elements\Fieldset $fieldset)
    {
        $fieldset->addChild($this->addTip([
            'tip' => '<p>' . $this->trans('This layout box does not need to be configured. All done :).') . '</p>'
        ]));
    }
} 