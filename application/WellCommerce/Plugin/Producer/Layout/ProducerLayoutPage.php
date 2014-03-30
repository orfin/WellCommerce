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
use WellCommerce\Core\Layout\Page\LayoutPage;
use WellCommerce\Core\Layout\Page\LayoutPageInterface;

/**
 * Class ProducerPageLayoutConfigurator
 *
 * @package WellCommerce\Plugin\Producer\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerLayoutPage extends LayoutPage implements LayoutPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLayoutXml()
    {
        return 'producer.xml';
    }
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