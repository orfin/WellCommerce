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

namespace WellCommerce\Plugin\Cart\Layout;

use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;

/**
 * Class CartBoxConfigurator
 *
 * @package WellCommerce\Plugin\Cart\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * @var string CartBoxConfigurator type
     */
    public $type;

    /**
     * @var string CartBoxController service name
     */
    public $controller;

    /**
     * @var string CartBoxConfigurator box name
     */
    public $name = 'CartBox';

}