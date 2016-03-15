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
 * Class AttributeFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('attribute.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $groupsData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'groups_data',
            'label' => $this->trans('attribute.fieldset.groups')
        ]));

        $groupsData->addChild($this->getElement('multi_select', [
            'name'        => 'groups',
            'label'       => $this->trans('attribute.label.groups'),
            'options'     => $this->get('attribute_group.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('attribute_group.repository'))
        ]));

        $valuesData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'values_data',
            'label' => $this->trans('attribute.fieldset.values')
        ]));

        $valuesData->addChild($this->getElement('multi_select', [
            'name'        => 'values',
            'label'       => $this->trans('attribute.label.values'),
            'options'     => $this->get('attribute_value.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('collection', $this->get('attribute_value.repository'))
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
