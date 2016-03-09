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
namespace WellCommerce\Bundle\TaxBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class TaxFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $taxForm)
    {
        $taxRequiredData = $taxForm->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $taxTranslationData = $taxRequiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('common.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('tax.repository'))
        ]));

        $taxTranslationData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $taxRequiredData->addChild($this->getElement('text_field', [
            'name'   => 'value',
            'label'  => $this->trans('tax.label.value'),
            'suffix' => '%',
            'rules'  => [
                $this->getRule('required')
            ],
        ]));

        $taxForm->addFilter($this->getFilter('no_code'));
        $taxForm->addFilter($this->getFilter('trim'));
        $taxForm->addFilter($this->getFilter('secure'));
    }
}
