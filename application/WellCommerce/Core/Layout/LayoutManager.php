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
namespace WellCommerce\Core\Layout;

use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;
use WellCommerce\Core\Layout\Page\LayoutPageInterface;

/**
 * Class LayoutManager
 *
 * @package WellCommerce\Core
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutManager extends AbstractComponent
{
    /**
     * @var array
     */
    private $layoutBoxConfigurators = [];

    /**
     * @var array
     */
    private $layoutPages = [];

    /**
     * Adds new layout box configurator to stack
     *
     * @param LayoutBoxConfiguratorInterface $configurator
     */
    public function addLayoutBoxConfigurator(LayoutBoxConfiguratorInterface $configurator)
    {
        $this->layoutBoxConfigurators[$configurator->getAlias()] = $configurator;
    }

    public function getLayoutBoxConfigurator($alias)
    {
        if (!isset($this->layoutBoxConfigurators[$alias])) {
            throw new \RuntimeException(sprintf('LayoutBoxConfigurator "%s" is not registered', $alias));
        }

        return $this->layoutBoxConfigurators[$alias];
    }

    /**
     * Adds new layout page configurator to stack
     *
     * @param LayoutPageInterface $configurator
     */
    public function addLayoutPage($alias, LayoutPageInterface $layoutPage)
    {
        $this->layoutPages[$alias] = $layoutPage;
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
    public function getLayoutPages()
    {
        return $this->layoutPages;
    }

    /**
     * Renders layout from xml file using given renderer
     *
     * @param $layout Renderer alias
     *
     * @throws \RuntimeException
     */
    public function renderLayout($layout)
    {
        if (!isset($this->layoutPages[$layout])) {
            throw new \RuntimeException(sprintf('Layout page "%s" is not registered', $layout));
        }

        $layoutPage = $this->layoutPages[$layout];

        return $layoutPage->render();
    }
}