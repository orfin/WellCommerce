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
namespace WellCommerce\Bundle\AttributeBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

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
            'label' => $this->trans('attribute_group.label.group')
        ]));

        $languageData = $groupData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('attribute_group.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $attributeData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'attribute_data',
            'class' => 'attribute-data',
            'label' => $this->trans('attribute_group.label.attributes')
        ]));

        $attributeData->addChild($this->getElement('attribute_editor', [
            'name'                         => 'attributes',
            'label'                        => $this->trans('attribute_group.label.attributes'),
            'set'                          => $this->getRequestHelper()->getAttributesBagParam('id'),
            'delete_attribute_route'       => 'admin.attribute.delete',
            'rename_attribute_route'       => 'admin.attribute.edit',
            'rename_attribute_value_route' => 'admin.attribute_value.edit',
            'attributes'                   => $this->get('attribute.repository')->getAttributesWithValues(),
            'transformer'                  => $this->getRepositoryTransformer('attribute_collection', $this->get('attribute.repository'))
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
