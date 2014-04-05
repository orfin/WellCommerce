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
use WellCommerce\Core\Layout\Box\LayoutBox;
use WellCommerce\Core\Layout\Column\LayoutColumnCollection;
use WellCommerce\Plugin\Layout\Repository\LayoutBoxRepository;

/**
 * Class LayoutRenderer
 *
 * @package WellCommerce\Core\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutRenderer extends AbstractComponent
{
    /**
     * @var array
     */
    private $columns = [];

    /**
     * @var array
     */
    private $repository = [];

    /**
     * Sets layout box repository
     *
     * @param LayoutBoxRepository $repository
     */
    public function setLayoutBoxRepository(LayoutBoxRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all boxes from repository
     *
     * @return array
     */
    private function getBoxes()
    {
        $collection = $this->repository->all()->toArray();
        $items      = [];

        foreach ($collection as $item) {
            $items[$item['identifier']] = $item;
        }

        return $items;
    }

    /**
     * Renders the whole layout
     *
     * @param LayoutColumnCollection $columns
     *
     * @return string
     */
    public function render(LayoutColumnCollection $columns)
    {
        $this->boxes   = $this->getBoxes();
        $this->columns = $columns->all();
        $content       = '';

        foreach ($this->columns as $index => $column) {
            $boxes     = $column->getBoxes();
            $boxesHtml = '';
            foreach ($boxes as $box) {
                $boxesHtml .= $this->getBoxContent($box);
            }

            $content .= $this->get('twig')->render($column->getTemplate(), [
                'id'    => $index,
                'width' => $column->getWidth(),
                'boxes' => $boxesHtml
            ]);
        }

        return $content;
    }

    /**
     * Prepares settings and flattens array
     *
     * @param $collection
     *
     * @return array
     */
    private function prepareBoxSettings($collection)
    {
        $settings = [];
        foreach ($collection as $setting) {
            $settings[$setting['param']] = $setting['value'];
        }

        return $settings;
    }

    /**
     * Forwards request to related box controller and returns its content
     *
     * @param LayoutBox $box
     *
     * @return mixed
     */
    private function getBoxContent(LayoutBox $box)
    {
        $alias    = $this->boxes[$box->getId()]['alias'];
        $settings = $this->prepareBoxSettings($this->boxes[$box->getId()]['settings']);

        // get box configurator
        $configurator = $this->getLayoutManager()->getLayoutBoxConfigurator($alias);

        // forward request to box controller and pass additional settings
        $content = $this->forward($configurator->getController(), 'indexAction', $settings);

        return $content->getContent();
    }
} 