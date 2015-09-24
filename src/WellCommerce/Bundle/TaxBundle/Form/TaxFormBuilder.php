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
namespace WellCommerce\Bundle\TaxBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

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
            'label' => $this->trans('form.required_data.label')
        ]));

        $taxRequiredData->addChild($this->getElement('text_field', [
            'name'  => 'value',
            'label' => $this->trans('tax.label.value'),
        ]));

        $taxTranslationData = $taxRequiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('form.translations.label'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('tax.repository'))
        ]));

        $taxTranslationData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('tax.label.name'),
        ]));

        $taxForm->addFilter($this->getFilter('no_code'));
        $taxForm->addFilter($this->getFilter('trim'));
        $taxForm->addFilter($this->getFilter('secure'));
    }
}
