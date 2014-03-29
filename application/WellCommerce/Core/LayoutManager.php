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
namespace WellCommerce\Core;

use WellCommerce\Core\Layout\LayoutBoxConfiguratorInterface;
use WellCommerce\Core\Layout\LayoutPageConfiguratorInterface;

/**
 * Class LayoutManager
 *
 * @package WellCommerce\Core
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutManager extends Component
{
    /**
     * @var array
     */
    private $layoutBoxConfigurators = [];

    /**
     * @var array
     */
    private $layoutPageConfigurators = [];

    /**
     * Adds new layout box configurator to stack
     *
     * @param LayoutBoxConfiguratorInterface $configurator
     */
    public function addLayoutBoxConfigurator(LayoutBoxConfiguratorInterface $configurator)
    {
        $this->layoutBoxConfigurators[$configurator->getAlias()] = $configurator;
    }

    /**
     * Adds new layout page configurator to stack
     *
     * @param LayoutPageConfiguratorInterface $configurator
     */
    public function addLayoutPageConfigurator(LayoutPageConfiguratorInterface $configurator)
    {
        $this->layoutPageConfigurators[$configurator->getAlias()] = $configurator;
    }

    /**
     * Returns all layout box configurators
     *
     * @return array
     */
    public function getLayoutBoxConfigurators()
    {
        return $this->layoutBoxConfigurators;
    }

    /**
     * Returns all layout page configurators
     *
     * @return array
     */
    public function getLayoutPageConfigurators()
    {
        return $this->layoutPageConfigurators;
    }

    public function renderLayout($layout)
    {
        $content = $this->forward('WellCommerce\Plugin\HomePage\Controller\Frontend\FooterController')->getContent();

        return $content;
    }

}