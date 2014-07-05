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
 * Class CategoryBoxConfigurator
 *
 * @package WellCommerce\Plugin\Category\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * Layout box name
     *
     * @var string
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