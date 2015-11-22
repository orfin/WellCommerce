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
namespace WellCommerce\PromotionBundle\Form\Admin;

use WellCommerce\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Conditions\Equals;
use WellCommerce\Component\Form\DataTransformer\DateTransformer;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class CouponForm
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponFormBuilder extends AbstractFormBuilder
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
            'label'       => $this->trans('form.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('coupon.repository'))
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
        ]));

        $languageData->addChild($this->getElement('text_area', [
            'name'  => 'description',
            'label' => $this->trans('common.label.description'),
        ]));

        $requiredData->addChild($this->getElement('date', [
            'name'        => 'validFrom',
            'label'       => $this->trans('common.label.valid_from'),
            'transformer' => new DateTransformer('m/d/Y'),
        ]));

        $requiredData->addChild($this->getElement('date', [
            'name'        => 'validTo',
            'label'       => $this->trans('common.label.valid_to'),
            'transformer' => new DateTransformer('m/d/Y'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'code',
            'label' => $this->trans('common.label.code'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'clientUsageLimit',
            'label' => $this->trans('coupon.label.client_usage_limit'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'globalUsageLimit',
            'label' => $this->trans('coupon.label.global_usage_limit'),
        ]));

        $discountPane = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'discount_pane',
            'label' => $this->trans('coupon.fieldset.discount_settings')
        ]));

        $modifierType = $discountPane->addChild($this->getElement('select', [
            'name'    => 'modifierType',
            'label'   => $this->trans('coupon.label.modifier_type'),
            'options' => $this->getModifierTypes()
        ]));

        $discountPane->addChild($this->getElement('select', [
            'name'         => 'currency',
            'label'        => $this->trans('common.label.currency'),
            'options'      => $this->get('currency.dataset.admin')->getResult('select'),
            'dependencies' => [
                $this->getDependency('show', [
                    'form'      => $form,
                    'field'     => $modifierType,
                    'condition' => new Equals('-')
                ])
            ]
        ]));

        $discountPane->addChild($this->getElement('text_field', [
            'name'  => 'modifierValue',
            'label' => $this->trans('coupon.label.modifier_value')
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }

    protected function getModifierTypes()
    {
        return [
            '%' => $this->trans('coupon.label.modifier_type_percent'),
            '-' => $this->trans('coupon.label.modifier_type_subtract'),
        ];
    }
}
