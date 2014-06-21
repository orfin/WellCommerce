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

use WellCommerce\Core\Component\Form\Conditions\Equals;
use WellCommerce\Core\Component\Form\Dependency;
use WellCommerce\Core\Component\Form\Option;
use WellCommerce\Core\Event\FormEvent;
use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;

/**
 * Class CategoryBoxConfigurator
 *
 * @package WellCommerce\Plugin\Category\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * @var string CategoryBoxConfigurator type
     */
    public $type;

    /**
     * @var string CategoryBoxController service name
     */
    public $controller;

    /**
     * @var string CategoryBoxController box name
     */
    public $name = 'CategoryBox';

    /**
     * {@inheritdoc}
     */
    public function addBoxConfiguration()
    {
        $this->fieldset->addChild($this->builder->addTip([
            'tip' => '<p>' . $this->trans('Choose categories that should be visible in category box or leave empty.') . '</p>'
        ]));

        $this->fieldset->addChild($this->builder->addTree([
            'name'       => 'category',
            'label'      => $this->trans('Categories'),
            'choosable'  => false,
            'selectable' => true,
            'sortable'   => false,
            'clickable'  => false,
            'items'      => $this->get('category.repository')->getCategoriesTree()
        ]));
    }
} 