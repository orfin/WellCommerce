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

use WellCommerce\Core\Component\Form\AbstractFormBuilder;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Plugin\Layout\Event\LayoutPageFormEvent;

/**
 * Class LayoutPageTree
 *
 * @package WellCommerce\Plugin\Category\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageTree extends AbstractFormBuilder implements FormInterface
{
    /**
     * Fetches all registered layout pages
     *
     * @return array
     */
    private function getTreeItems()
    {
        $themes = $this->get('layout_theme.repository')->all();

        $items = [];

        foreach ($themes as $theme) {
            $items[$theme->id] = [
                'name'   => $theme->name . ' <small>(' . $theme->folder . ')</small>',
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
            'label'              => $this->trans('Choose site theme to edit'),
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

        $event = new LayoutPageFormEvent($form, $layoutPageData);

        $this->getDispatcher()->dispatch(LayoutPageFormEvent::TREE_INIT_EVENT, $event);

        $form->Populate($event->getPopulateData());

        return $form;
    }
}
