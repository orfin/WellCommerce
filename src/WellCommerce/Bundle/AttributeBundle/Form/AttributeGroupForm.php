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
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class AttributeGroupForm
 *
 * @package WellCommerce\Bundle\AttributeBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $groupData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'group_data',
            'class' => 'group-data',
            'label' => $this->trans('Attribute group')
        ]));

        $languageData = $groupData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('form.required_data.language_data.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('Group name'),
        ]));

        $attributeData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'attribute_data',
            'class' => 'attribute-data',
            'label' => $this->trans('Attributes')
        ]));

        $attributeData->addChild($builder->getElement('attribute_editor', [
            'name'                         => 'attributes',
            'label'                        => $this->trans('Attributes'),
            'set'                          => $this->getParam('id'),
            'delete_attribute_route'       => 'admin.attribute.delete',
            'rename_attribute_route'       => 'admin.attribute.edit',
            'rename_attribute_value_route' => 'admin.attribute_value.edit',
            'attributes'                   => $this->get('attribute.repository')->findAll(),
            'transformer'                  => new AttributeCollectionToArrayTransformer($this->get('attribute.repository'))
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
