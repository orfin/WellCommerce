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

use WellCommerce\Core\Component\Form\Elements\Fieldset;
use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;

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
    public function getController()
    {
        return 'WellCommerce\\Plugin\\Contact\\Controller\\Frontend\\ContactBoxController';
    }

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
    public function addConfigurationFields(Fieldset $fieldset)
    {
        $fieldset->addChild($this->addTip([
            'tip' => '<p>' . sprintf($this->trans('Choose configuration options related to box "%s".'), $this->getAlias()) . '</p>'
        ]));
    }
} 