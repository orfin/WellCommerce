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

use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class PageForm
 *
 * @package WellCommerce\Bundle\CmsBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $mainData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'main_data',
            'label' => $this->trans('fieldset.main.label')
        ]));

        $languageData = $mainData->addChild($builder->getElement('language_fieldset', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.translations.label')
        ]));

        $name = $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('page.name.label'),
        ]));

        $languageData->addChild($builder->getElement('slug_field', [
            'name'            => 'slug',
            'label'           => $this->trans('page.slug.label'),
            'name_field'      => $name,
            'generate_route'  => 'admin.routing.generate',
            'translatable_id' => $this->getParam('id')
        ]));

        $mainData->addChild($builder->getElement('checkbox', [
            'name'    => 'publish',
            'label'   => $this->trans('page.publish.label'),
            'comment' => $this->trans('page.publish.help'),
            'default' => 1
        ]));

        $mainData->addChild($builder->getElement('text_field', [
            'name'    => 'hierarchy',
            'label'   => $this->trans('page.hierarchy.label'),
            'default' => 0
        ]));

        $mainData->addChild($builder->getElement('tree', [
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

        $contentData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'content_data',
            'label' => $this->trans('fieldset.content.label')
        ]));

        $languageData = $contentData->addChild($builder->getElement('language_fieldset', [
            'name'  => 'translations',
            'label' => $this->trans('fieldset.translations.label')
        ]));

        $languageData->addChild($builder->getElement('rich_text_editor', [
            'name'  => 'content',
            'label' => $this->trans('page.content.label'),
        ]));

        $form->addFilter($builder->getFilter('trim'));
        $form->addFilter($builder->getFilter('secure'));

        return $form;
    }
}
