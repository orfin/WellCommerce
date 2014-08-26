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

namespace WellCommerce\Bundle\LayoutBundle\Manager;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutPageColumn;
use WellCommerce\Bundle\LayoutBundle\Manager\Box\LayoutBox;
use WellCommerce\Bundle\LayoutBundle\Manager\Box\LayoutBoxCollection;
use WellCommerce\Bundle\LayoutBundle\Manager\Column\LayoutColumn;
use WellCommerce\Bundle\LayoutBundle\Manager\Column\LayoutColumnCollection;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox as LayoutBoxModel;
/**
 * Class LayoutRenderer
 *
 * @package WellCommerce\Bundle\LayoutBundle\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutRenderer extends AbstractContainer
{
    /**
     * Default controller action name
     */
    const DEFAULT_ACTION = 'indexAction';

    /**
     * Loads layout and returns a column collection with boxes
     *
     * @param LayoutInterface $layout Layout object
     *
     * @return LayoutColumnCollection
     */
    public function load(LayoutInterface $layout)
    {
        $columns    = $layout->getColumns();
        $collection = new LayoutColumnCollection();

        foreach ($columns as $column) {
            $this->addColumn($collection, $column);
        }

        return $collection;
    }

    /**
     * Adds new column to collection
     *
     * @param LayoutColumnCollection $collection
     * @param LayoutPageColumn       $layoutPageColumn
     */
    private function addColumn(LayoutColumnCollection $collection, LayoutPageColumn $layoutPageColumn)
    {
        $boxCollection         = new LayoutBoxCollection();
        $layoutPageColumnBoxes = $layoutPageColumn->getBoxes();

        /**
         * @var \WellCommerce\Bundle\LayoutBundle\Entity\LayoutPageColumnBox $box
         */
        foreach ($layoutPageColumnBoxes as $box) {
            $this->addBox($boxCollection, $box->getBox(), $box->getSpan());
        }

        $column = new LayoutColumn($layoutPageColumn->getWidth(), $boxCollection);
        $collection->add($column);
    }


    private function addBox(LayoutBoxCollection $collection, LayoutBoxModel $box, $span)
    {
        $configurator = $box->getBoxType()->getConfiguratorService();
        $layoutBox    = new LayoutBox($box, $this->getBoxController($configurator), $span);

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
//        $refClass      = new \ReflectionClass($configurator->class);
//        $currentAction = $this->getControllerActionFromRequest();
//        if ($refClass->hasMethod($this->getControllerActionFromRequest())) {
//            $action = $currentAction;
//        } else {
//            $action = self::DEFAULT_ACTION;
//        }
//        $controller = sprintf('%s:%s', $configurator->controller, $action);
//
//        return $controller;
    }
}