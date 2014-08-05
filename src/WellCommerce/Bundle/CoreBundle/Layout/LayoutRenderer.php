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

namespace WellCommerce\Bundle\CoreBundle\Layout;

use WellCommerce\Bundle\CoreBundle\AbstractComponent;
use WellCommerce\Bundle\CoreBundle\Layout\Box\LayoutBox;
use WellCommerce\Bundle\CoreBundle\Layout\Box\LayoutBoxCollection;
use WellCommerce\Bundle\CoreBundle\Layout\Column\LayoutColumn;
use WellCommerce\Bundle\CoreBundle\Layout\Column\LayoutColumnCollection;
use WellCommerce\Layout\Model\LayoutPageColumnBox;
use WellCommerce\Layout\Repository\LayoutRepositoryInterface;

/**
 * Class LayoutRenderer
 *
 * @package WellCommerce\Bundle\CoreBundle\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutRenderer extends AbstractComponent
{
    /**
     * Default controller action name
     */
    const DEFAULT_ACTION = 'indexAction';

    /**
     * @var LayoutRepositoryInterface Repository object
     */
    private $repository;

    /**
     * Sets repository object
     *
     * @param LayoutRepositoryInterface $repository
     */
    public function setLayoutRepository(LayoutRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns cache name
     *
     * @param $layout
     *
     * @return string
     */
    private function getCacheKey($layout)
    {
        return sprintf('layout_%s', $layout);
    }

    /**
     * Loads layout and returns a column collection with boxes
     *
     * @param LayoutInterface $layout Layout object
     *
     * @return LayoutColumnCollection
     */
    public function load(LayoutInterface $layout)
    {
        if ($layout->isCacheEnabled()) {
            $cacheKey = $this->getCacheKey($layout->getName());
            if ($this->getCache()->hasItem($cacheKey)) {
                $collection = $this->getCache()->getItem($cacheKey);
            } else {
                $collection = $this->getLayoutColumnCollection($layout->getName());
                $this->getCache()->addItem($cacheKey, $collection);
            }
        } else {
            $collection = $this->getLayoutColumnCollection($layout->getName());
        }

        return $collection;
    }

    /**
     * Returns LayoutColumnCollection for Layout
     *
     * @param $name Layout name
     *
     * @return LayoutColumnCollection
     */
    private function getLayoutColumnCollection($name)
    {
        $layoutPage = $this->repository->find($name);
        if (!$layoutPage) {
            throw new \InvalidArgumentException(sprintf('Layout page "%s" not found. Maybe you misspelled name or page is not registered?', $name));
        }
        $collection = new LayoutColumnCollection();
        foreach ($layoutPage->column as $item) {
            $this->addColumn($collection, $item);
        }

        return $collection;
    }

    /**
     * Adds new column to collection
     *
     * @param LayoutColumnCollection $collection
     * @param                        $item
     */
    private function addColumn(LayoutColumnCollection $collection, $layoutPageColumn)
    {
        $boxCollection = new LayoutBoxCollection();
        foreach ($layoutPageColumn->boxes as $item) {
            $this->addBox($boxCollection, $item);
        }

        $column = new LayoutColumn($layoutPageColumn->width, $boxCollection);
        $collection->add($column);
    }

    /**
     * Adds new box to related column collection
     *
     * @param LayoutBoxCollection $collection
     * @param LayoutPageColumnBox $box
     */
    private function addBox(LayoutBoxCollection $collection, LayoutPageColumnBox $box)
    {
        // prepare layout box
        $configurator = $this->getLayoutManager()->getLayoutBoxConfigurator($box->box->type);
        $layoutBox    = new LayoutBox($box, $this->getBoxController($configurator));

        // add box to collection
        $collection->add($layoutBox);
    }

    /**
     * Returns full service name with action used in forwarded requests
     *
     * @param $configurator
     *
     * @return mixed
     */
    private function getBoxController($configurator)
    {
        $refClass      = new \ReflectionClass($configurator->class);
        $currentAction = $this->getControllerActionFromRequest();
        if ($refClass->hasMethod($this->getControllerActionFromRequest())) {
            $action = $currentAction;
        } else {
            $action = self::DEFAULT_ACTION;
        }
        $controller = sprintf('%s:%s', $configurator->controller, $action);

        return $controller;
    }
}