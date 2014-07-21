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
namespace WellCommerce\Attribute\Form;

use WellCommerce\Core\Form\AbstractForm;
use WellCommerce\Core\Form\Builder\FormBuilder;
use WellCommerce\Core\Form\FormInterface;
use WellCommerce\Attribute\Model\Attribute;
use WellCommerce\Attribute\Model\AttributeGroup;

/**
 * Class AttributeForm
 *
 * @package WellCommerce\Attribute\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $form = $builder->addForm($options);

        $groupData = $form->addChild($builder->addFieldset([
            'name'  => 'group_data',
            'class' => 'group-data',
            'label' => $this->trans('Attribute groups')
        ]));

        $basicLanguageData = $groupData->addChild($builder->addFieldsetLanguage([
            'name'  => 'language_data',
            'label' => $this->trans('Translations'),
        ]));

        $basicLanguageData->addChild($builder->addTextField([
            'name'  => 'name',
            'label' => $this->trans('Group name'),
            'rules' => [
                $builder->addRuleRequired('Group name is required'),
                $builder->addRuleUnique($this->trans('Group name already exists'),
                    [
                        'table'   => 'attribute_group_translation',
                        'column'  => 'name',
                        'exclude' => [
                            'column' => 'attribute_group_id',
                            'values' => $this->getParam('id')
                        ]
                    ]
                ),

            ]
        ]));

        $attributeData = $form->addChild($builder->addFieldset([
            'name'  => 'attribute_data',
            'class' => 'attribute-data',
            'label' => $this->trans('Attributes')
        ]));

        $attributeData->addChild($builder->addAttributeEditor([
            'name'  => 'attributes',
            'label' => $this->trans('Attributes'),
            'set'   => $this->getParam('id')
        ]));

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * Prepares form data using retrieved model
     *
     * @param Attribute $attribute Model
     *
     * @return array
     */
    public function prepareData(AttributeGroup $attributeGroup)
    {
        $formData     = [];
        $accessor     = $this->getPropertyAccessor();
        $languageData = $attributeGroup->translations->getTranslations();

        $accessor->setValue($formData, '[group_data]', [
            'language_data' => $languageData
        ]);

        return $formData;
    }
}
