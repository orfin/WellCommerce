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
namespace WellCommerce\Plugin\Layout\Form;

use WellCommerce\Core\Form;
use WellCommerce\Plugin\Category\Event\CategoryFormEvent;
use WellCommerce\Plugin\Layout\Event\LayoutPageFormEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class LayoutPageTree
 *
 * @package WellCommerce\Plugin\Category\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageTree extends Form
{
    /**
     * Fetches all registered layout pages
     *
     * @return array
     */
    private function getTreeItems()
    {
        $pages = $this->getLayoutManager()->getLayoutPageConfigurators();

        $items = [];

        foreach ($pages as $id => $configurator) {
            $items[$id] = [
                'name'   => $this->trans($configurator->getName()) . ' <small>(' . $id . ')</small>',
                'parent' => null,
                'weight' => 0
            ];
        }

        return $items;
    }

    public function init($layoutPageData = Array())
    {
        $form = $this->addForm([
            'name'  => 'layout_page_tree',
            'class' => 'category-select',
        ]);

        $id     = $this->getParam('id');
        $page   = $this->getParam('page');
        $active = ($page == null) ? $id : sprintf('%s,%s', $id, $page);

        $form->addChild($this->addTree([
            'name'               => 'layout_page',
            'label'              => $this->trans('Choose page to edit'),
            'sortable'           => false,
            'selectable'         => false,
            'clickable'          => true,
            'deletable'          => false,
            'addable'            => false,
            'prevent_duplicates' => false,
            'items'              => $this->getTreeItems(),
            'onClick'            => 'openLayoutPageEditor',
            'active'             => $active,
            'clickable_root'     => false
        ]));

        $form->AddFilter($this->addFilterNoCode());
        $form->AddFilter($this->addFilterSecure());

        $event = new CategoryFormEvent($form, $layoutPageData);

        $this->getDispatcher()->dispatch(CategoryFormEvent::TREE_INIT_EVENT, $event);

        $form->Populate($event->getPopulateData());

        return $form;
    }
}
