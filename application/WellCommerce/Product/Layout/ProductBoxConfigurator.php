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

namespace WellCommerce\Product\Layout;

use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;

/**
 * Class ProductBoxConfigurator
 *
 * @package WellCommerce\Product\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    public $name = 'ProductBox';

    /**
     * {@inheritdoc}
     */
    public function isAvailableForLayoutPage($layoutPage)
    {
        return ($layoutPage == 'Product');
    }


} 