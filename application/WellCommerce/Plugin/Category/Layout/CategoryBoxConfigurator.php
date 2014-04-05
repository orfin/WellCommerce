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

use WellCommerce\Core\Component\Form\Elements\Fieldset;
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
     * {@inheritdoc}
     */
    public function getController()
    {
        return 'WellCommerce\\Plugin\\Category\\Controller\\Frontend\\CategoryBoxController';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Category';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'wellcommerce.box.category';
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailableForLayoutPage($layoutPage)
    {
        // available on all layout pages
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields(Fieldset $fieldset)
    {
        $fieldset->addChild($this->addTip([
            'tip' => '<p>' . $this->trans('Choose categories that should be visible in category box or leave empty.') . '</p>'
        ]));

        $fieldset->addChild($this->addTree([
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