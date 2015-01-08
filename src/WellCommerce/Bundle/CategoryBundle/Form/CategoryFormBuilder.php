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

use WellCommerce\Bundle\CoreBundle\Form\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class CategoryForm
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
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
            'transformer' => new TranslationTransformer($this->get('category.repository'))
        ]));

        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('category.name.label'),
        ]));

        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('category.slug.label'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('category.enabled.label'),
            'comment' => $this->trans('category.enabled.comment'),
            'default' => 1
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'hierarchy',
            'label' => $this->trans('category.hierarchy.label'),
        ]));

        $requiredData->addChild($this->getElement('tip', [
            'tip' => '<p>' . $this->trans('category.parent.help') . '</p>'
        ]));

        $requiredData->addChild($this->getElement('tree', [
            'name'        => 'parent',
            'label'       => $this->trans('category.parent.label'),
            'choosable'   => true,
            'selectable'  => false,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('category.repository')->getTreeItems(),
            'restrict'    => $this->getParam('id'),
            'transformer' => new EntityToIdentifierTransformer($this->get('category.repository'))
        ]));

        $descriptionData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'description_data',
            'label' => $this->trans('fieldset.description')
        ]));

        $languageData = $descriptionData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.translations'),
            'transformer' => new TranslationTransformer($this->get('category.repository'))
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
            'transformer' => new TranslationTransformer($this->get('category.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'metaTitle',
            'label' => $this->trans('category.meta_title.label')
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'metaKeywords',
            'label' => $this->trans('category.meta_keywords.label'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'metaDescription',
            'label' => $this->trans('category.meta_description.label'),
        ]));

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
