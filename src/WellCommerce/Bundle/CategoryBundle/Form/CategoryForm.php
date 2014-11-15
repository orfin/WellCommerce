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
            'label' => $this->trans('fieldset.required')
        ]));

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.translations'),
        ]));

        $name = $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('category.name.label'),
        ]));

        $languageData->addChild($builder->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('category.slug.label'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'hierarchy',
            'label' => $this->trans('category.hierarchy.label'),
        ]));

        $requiredData->addChild($builder->getElement('tip', [
            'tip' => '<p>' . $this->trans('category.parent.help') . '</p>'
        ]));

        $requiredData->addChild($builder->getElement('tree', [
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

        $descriptionData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'description_data',
            'label' => $this->trans('fieldset.description')
        ]));

        $languageData = $descriptionData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.translations'),
        ]));

        $languageData->addChild($builder->getElement('rich_text_editor', [
            'name'  => 'shortDescription',
            'label' => $this->trans('category.short_description.label')
        ]));

        $languageData->addChild($builder->getElement('rich_text_editor', [
            'name'  => 'description',
            'label' => $this->trans('category.description.label'),
        ]));

        $seoData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'seo_data',
            'label' => $this->trans('fieldset.seo')
        ]));

        $languageData = $seoData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.translations'),
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'metaTitle',
            'label' => $this->trans('category.meta_title.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'metaKeywords',
            'label' => $this->trans('category.meta_keywords.label'),
        ]));

        $languageData->addChild($builder->getElement('text_area', [
            'name'  => 'metaDescription',
            'label' => $this->trans('category.meta_description.label'),
        ]));

        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
