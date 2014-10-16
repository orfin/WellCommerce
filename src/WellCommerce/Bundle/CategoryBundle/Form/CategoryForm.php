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

use WellCommerce\Bundle\FormBundle\Form\AbstractForm;
use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\FormBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;

/**
 * Class CategoryForm
 *
 * @package WellCommerce\Category\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data')
        ]));

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('form.required_data.language_data.label'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('category.name'),
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'hierarchy',
            'label' => $this->trans('Hierarchy'),
        ]));

        $requiredData->addChild($builder->getElement('tip', [
            'tip' => '<p>' . $this->trans('Choose parent category') . '</p>'
        ]));

        $requiredData->addChild($builder->getElement('tree', [
            'name'        => 'parent',
            'label'       => $this->trans('category.parent'),
            'choosable'   => true,
            'selectable'  => false,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('category.repository')->getTreeItems(),
            'restrict'    => $this->getParam('id'),
            'transformer' => new EntityToIdentifierTransformer($this->get('category.repository'))
        ]));

        $shopData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'shop_data',
            'label' => $this->trans('shops')
        ]));

        $shopData->addChild($builder->getElement('multi_select', [
            'name'        => 'shops',
            'label'       => $this->trans('shops'),
            'options'     => $this->get('shop.repository')->getCollectionToSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('shop.repository'))
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
