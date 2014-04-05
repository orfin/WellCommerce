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

namespace WellCommerce\Plugin\Producer\Layout;

use WellCommerce\Core\Component\Form\Elements\Fieldset;
use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;

/**
 * Class ProducerBoxConfigurator
 *
 * @package WellCommerce\Plugin\Producer\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerListBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getController()
    {
        return 'WellCommerce\\Plugin\\ProducerList\\Controller\\Frontend\\ProducerListBoxController';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Producer list';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'wellcommerce.box.producer_list';
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailableForLayoutPage($layoutPage)
    {
        return ($layoutPage == 'ProducerList');
    }

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields(Fieldset $fieldset)
    {
        return false;
    }
} 