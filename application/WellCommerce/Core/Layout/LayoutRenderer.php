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

use WellCommerce\Core\Component;
use WellCommerce\Core\Layout\Box\LayoutBox;
use WellCommerce\Core\Layout\Column\LayoutColumnCollection;
use WellCommerce\Plugin\Layout\Repository\LayoutBoxRepository;

/**
 * Class LayoutRenderer
 *
 * @package WellCommerce\Core\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutRenderer extends Component
{
    private $columns = [];
    private $repository = [];

    public function setLayoutBoxRepository(LayoutBoxRepository $repository)
    {
        $this->repository = $repository;
    }

    private function getBoxes()
    {
        $collection = $this->repository->all()->toArray();
        $items      = [];

        foreach ($collection as $item) {
            $items[$item['identifier']] = $item;
        }

        return $items;
    }

    public function render(LayoutColumnCollection $columns)
    {
        $this->boxes   = $this->getBoxes();
        $this->columns = $columns->all();
        $content       = '';

        foreach ($this->columns as $column) {
            $boxes = $column->getBoxes();
            foreach ($boxes as $box) {
                $content .= $this->getBoxContent($box);
            }
        }

        return $content;
    }

    private function getBoxContent(LayoutBox $box)
    {
        $alias        = $this->boxes[$box->getId()]['alias'];
        $configurator = $this->getLayoutManager()->getLayoutBoxConfigurator($alias);

        $content = $this->forward($configurator->getController());
        return $content->getContent();
    }
} 