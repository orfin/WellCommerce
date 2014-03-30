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

namespace WellCommerce\Plugin\Product\Layout;

use WellCommerce\Core\Form;
use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;

/**
 * Class ProductBoxConfigurator
 *
 * @package WellCommerce\Plugin\Product\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getController()
    {
        return 'WellCommerce\\Plugin\\Product\\Controller\\Frontend\\ProductBoxController';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Product';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'wellcommerce.box.product';
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailableForLayoutPage($layoutPage)
    {
        return ($layoutPage == 'Product');
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