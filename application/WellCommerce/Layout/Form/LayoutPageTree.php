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
namespace WellCommerce\Layout\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilderInterface;
use WellCommerce\Core\Component\Form\FormInterface;

/**
 * Class LayoutPageTree
 *
 * @package WellCommerce\Category\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageTree extends AbstractForm implements FormInterface
{
    /**
     * Fetches all registered layout pages
     *
     * @return array
     */
    private function getTreeItems()
    {
        $themes = $this->get('layout_theme.repository')->all();
        $items  = [];

        foreach ($themes as $theme) {
            $items[$theme->id] = [
                'name'        => $theme->name . ' <small>(' . $theme->folder . ')</small>',
                'parent'      => null,
                'weight'      => 0,
                'hasChildren' => false
            ];
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->addForm($options);

        $form->addChild($builder->addTree([
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
            'active'             => (int)$this->getParam('id'),
            'clickable_root'     => false
        ]));

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }
}
