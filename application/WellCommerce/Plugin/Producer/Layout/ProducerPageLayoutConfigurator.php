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

use WellCommerce\Core\Form;
use WellCommerce\Core\Layout\LayoutPageConfiguratorInterface;
use WellCommerce\Core\Layout\Page\LayoutPageConfigurator;

/**
 * Class ProducerPageLayoutConfigurator
 *
 * @package WellCommerce\Plugin\Producer\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerPageLayoutConfigurator extends LayoutPageConfigurator implements LayoutPageConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Producer';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'Producer';
    }
}