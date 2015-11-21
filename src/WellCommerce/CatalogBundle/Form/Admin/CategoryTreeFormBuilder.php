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
namespace WellCommerce\CatalogBundle\Form\Admin;

use WellCommerce\CoreBundle\Component\Form\AbstractFormBuilder;
use WellCommerce\CoreBundle\Component\Form\Elements\FormInterface;

/**
 * Class CategoryTreeFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryTreeFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $form->addChild($this->getElement('tree', [
            'name'               => 'categories',
            'label'              => $this->trans('category.tree.label'),
            'add_item_prompt'    => $this->trans('category.name.label'),
            'addLabel'           => $this->trans('category.add.label'),
            'sortable'           => false,
            'selectable'         => false,
            'clickable'          => true,
            'deletable'          => true,
            'addable'            => true,
            'prevent_duplicates' => true,
            'items'              => $this->get('category.dataset.admin')->getResult('flat_tree'),
            'onClick'            => 'openCategoryEditor',
            'onDuplicate'        => 'duplicateCategory',
            'onSaveOrder'        => 'changeOrder',
            'onAdd'              => 'addCategory',
            'onAfterAdd'         => 'openCategoryEditor',
            'onDelete'           => 'deleteCategory',
            'onAfterDelete'      => 'openCategoryEditor',
            'active'             => (int)$this->getRequestHelper()->getAttributesBagParam('id')
        ]));
    }
}
