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

namespace WellCommerce\Plugin\Category\Layout;

use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;

/**
 * Class CategoryInfoBoxConfigurator
 *
 * @package WellCommerce\Plugin\Category\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryInfoBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    public $name = 'CategoryInfoBox';

    /**
     * {@inheritdoc}
     */
    public function isAvailableForLayoutPage($layoutPage)
    {
        return ($layoutPage == 'Category');
    }
}