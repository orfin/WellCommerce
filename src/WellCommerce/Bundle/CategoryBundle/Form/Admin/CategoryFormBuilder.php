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
namespace WellCommerce\Bundle\CategoryBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class CategoryForm
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('category.repository'))
        ]));

        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ]
        ]));

        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('category.label.slug'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getRequestHelper()->getAttributesBagParam('id'),
            'rules'           => [
                $this->getRule('required')
            ]
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('category.label.enabled'),
            'comment' => $this->trans('category.comment.enabled'),
            'default' => 1
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'hierarchy',
            'label' => $this->trans('common.label.hierarchy'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $requiredData->addChild($this->getElement('tree', [
            'name'        => 'parent',
            'label'       => $this->trans('category.label.parent'),
            'choosable'   => true,
            'selectable'  => false,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('category.dataset.admin')->getResult('flat_tree'),
            'restrict'    => $this->getRequestHelper()->getAttributesBagParam('id'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('category.repository'))
        ]));

        $descriptionData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'description_data',
            'label' => $this->trans('category.form.fieldset.description')
        ]));

        $languageData = $descriptionData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('category.repository'))
        ]));

        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'shortDescription',
            'label' => $this->trans('common.label.short_description')
        ]));
        
        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'description',
            'label' => $this->trans('common.label.description'),
        ]));

        $this->addMetadataFieldset($form, $this->get('category.repository'));

        $this->addShopsFieldset($form);

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
