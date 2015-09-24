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

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

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
            'label' => $this->trans('fieldset.required')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('category.repository'))
        ]));

        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('category.label.name'),
        ]));

        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('category.label.slug'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('category.label.enabled'),
            'comment' => $this->trans('category.comment.enabled'),
            'default' => 1
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'hierarchy',
            'label' => $this->trans('category.label.hierarchy'),
        ]));

        $requiredData->addChild($this->getElement('tree', [
            'name'        => 'parent',
            'label'       => $this->trans('category.label.parent'),
            'choosable'   => true,
            'selectable'  => false,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('category.collection.admin')->getFlatTree(),
            'restrict'    => $this->getParam('id'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('category.repository'))
        ]));

        $descriptionData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'description_data',
            'label' => $this->trans('fieldset.description')
        ]));

        $languageData = $descriptionData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('category.repository'))
        ]));

        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'shortDescription',
            'label' => $this->trans('category.short_description.label')
        ]));

        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'description',
            'label' => $this->trans('category.description.label'),
        ]));

        $seoData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'seo_data',
            'label' => $this->trans('fieldset.seo')
        ]));

        $languageData = $seoData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('category.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'meta.title',
            'label' => $this->trans('meta.title.label')
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'meta.keywords',
            'label' => $this->trans('meta.keywords.label'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'meta.description',
            'label' => $this->trans('meta.description.label'),
        ]));

        $shopsData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shops_data',
            'label' => $this->trans('fieldset.shops.label')
        ]));

        $shopsData->addChild($this->getElement('multi_select', [
            'name'        => 'shops',
            'label'       => $this->trans('category.label.shops'),
            'options'     => $this->get('shop.collection')->getSelect(),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('shop.repository'))
        ]));

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
