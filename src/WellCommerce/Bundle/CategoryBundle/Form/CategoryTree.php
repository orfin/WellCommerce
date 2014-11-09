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
namespace WellCommerce\Bundle\CategoryBundle\Form;

use WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface;
use WellCommerce\Bundle\FormBundle\Form\AbstractForm;
use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;

/**
 * Class CategoryForm
 *
 * @package WellCommerce\Category\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryTree extends AbstractForm implements FormInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $form->addChild($builder->getElement('tree', [
            'name'               => 'categories',
            'label'              => $this->trans('Categories'),
            'add_item_prompt'    => $this->trans('Category name'),
            'addLabel'           => $this->trans('Add category'),
            'sortable'           => false,
            'selectable'         => false,
            'clickable'          => true,
            'deletable'          => true,
            'addable'            => true,
            'prevent_duplicates' => true,
            'items'              => $this->repository->getTreeItems(),
            'onClick'            => 'openCategoryEditor',
            'onDuplicate'        => 'duplicateCategory',
            'onSaveOrder'        => 'changeOrder',
            'onAdd'              => 'addCategory',
            'onAfterAdd'         => 'openCategoryEditor',
            'onDelete'           => 'deleteCategory',
            'onAfterDelete'      => 'openCategoryEditor',
            'active'             => (int)$this->getRequest()->attributes->get('id')
        ]));

        return $form;
    }

    /**
     * Sets repository object
     *
     * @param CategoryRepositoryInterface $repository
     */
    public function setRepository(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
