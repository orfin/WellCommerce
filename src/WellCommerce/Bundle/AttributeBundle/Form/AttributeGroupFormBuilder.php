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
namespace WellCommerce\Bundle\AttributeBundle\Form;

use WellCommerce\Bundle\AttributeBundle\Form\DataTransformer\AttributeCollectionToArrayTransformer;
use WellCommerce\Bundle\CoreBundle\Form\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\TranslationTransformer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class AttributeGroupForm
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $groupData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'group_data',
            'class' => 'group-data',
            'label' => $this->trans('Attribute group')
        ]));

        $languageData = $groupData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('form.required_data.language_data.label'),
            'transformer' => new TranslationTransformer($this->get('category.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('Group name'),
        ]));

        $attributeData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'attribute_data',
            'class' => 'attribute-data',
            'label' => $this->trans('Attributes')
        ]));

        $attributeData->addChild($this->getElement('attribute_editor', [
            'name'                         => 'attributes',
            'label'                        => $this->trans('Attributes'),
            'set'                          => $this->getParam('id'),
            'delete_attribute_route'       => 'admin.attribute.delete',
            'rename_attribute_route'       => 'admin.attribute.edit',
            'rename_attribute_value_route' => 'admin.attribute_value.edit',
            'attributes'                   => $this->get('attribute.repository')->findAll(),
            'transformer'                  => new AttributeCollectionToArrayTransformer($this->get('attribute.repository'))
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
