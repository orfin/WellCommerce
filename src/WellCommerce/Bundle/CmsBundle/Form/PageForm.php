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
namespace WellCommerce\Bundle\CmsBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class PageForm
 *
 * @package WellCommerce\Bundle\CmsBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageForm extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $form = $builder->init($options);

        $mainData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'main_data',
            'label' => $this->trans('fieldset.main.label')
        ]));

        $languageData = $mainData->addChild($this->getElement('language_fieldset', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.translations.label')
        ]));

        $name = $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('page.name.label'),
        ]));

        $languageData->addChild($this->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('page.slug.label'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $mainData->addChild($this->getElement('checkbox', [
            'name'    => 'publish',
            'label'   => $this->trans('page.publish.label'),
            'comment' => $this->trans('page.publish.help'),
            'default' => 1
        ]));

        $mainData->addChild($this->getElement('text_field', [
            'name'    => 'hierarchy',
            'label'   => $this->trans('page.hierarchy.label'),
            'default' => 0
        ]));

        $mainData->addChild($this->getElement('tree', [
            'name'        => 'parent',
            'label'       => $this->trans('page.parent.label'),
            'choosable'   => true,
            'selectable'  => false,
            'sortable'    => false,
            'clickable'   => false,
            'items'       => $this->get('page.repository')->getTreeItems(),
            'restrict'    => $this->getParam('id'),
            'transformer' => new EntityToIdentifierTransformer($this->get('page.repository'))
        ]));

        $contentData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'content_data',
            'label' => $this->trans('fieldset.content.label')
        ]));

        $languageData = $contentData->addChild($this->getElement('language_fieldset', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.translations.label')
        ]));

        $languageData->addChild($this->getElement('rich_text_editor', [
            'name'  => 'content',
            'label' => $this->trans('page.content.label'),
        ]));

        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));

        return $form;
    }
}
