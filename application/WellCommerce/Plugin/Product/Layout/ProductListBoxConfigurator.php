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

namespace WellCommerce\Plugin\Product\Layout;

use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;

/**
 * Class ProductBoxConfigurator
 *
 * @package WellCommerce\Plugin\Product\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductListBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    public $name = 'ProductListBox';

    /**
     * {@inheritdoc}
     */
    public function isAvailableForLayoutPage($layoutPage)
    {
        return ($layoutPage == 'Category');
    }

    /**
     * {@inheritdoc}
     */
    public function addBoxConfiguration()
    {
        $this->fieldset->addChild($this->builder->addCheckbox([
            'name'    => 'pagination_enabled',
            'label'   => $this->trans('Pagination enabled'),
            'default' => 1
        ]));
    }
}