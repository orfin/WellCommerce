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
namespace WellCommerce\Bundle\ProductBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class ProductStatusFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $mainData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('fieldset.main.label')
        ]));

        $languageData = $mainData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.translations.label'),
            'transformer' => new TranslationTransformer($this->get('product_status.repository'))
        ]));

        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('product_status.name.label'),
        ]));

        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('product_status.slug.label'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'    => 'cssClass',
            'label'   => $this->trans('product_status.css_class.label'),
            'comment' => $this->trans('product_status.css_class.comment'),
        ]));

        $metaData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'meta_data',
            'label' => $this->trans('fieldset.meta.label')
        ]));

        $languageData = $metaData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('fieldset.translations.label'),
            'transformer' => new TranslationTransformer($this->get('product.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'metaTitle',
            'label' => $this->trans('meta.label.title')
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'metaKeywords',
            'label' => $this->trans('meta.label.keywords'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'metaDescription',
            'label' => $this->trans('meta.label.description'),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
