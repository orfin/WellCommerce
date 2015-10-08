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
namespace WellCommerce\Bundle\UnitBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class UnitFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $unitForm)
    {
        $unitRequiredData = $unitForm->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.fieldset.required_data')
        ]));

        $unitTranslationData = $unitRequiredData->addChild($this->getElement('language_fieldset', [
            'name'        => 'translations',
            'label'       => $this->trans('form.fieldset.translations'),
            'transformer' => $this->getRepositoryTransformer('translation', $this->get('product.repository'))
        ]));

        $unitTranslationData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
        ]));

        $unitForm->addFilter($this->getFilter('no_code'));
        $unitForm->addFilter($this->getFilter('trim'));
        $unitForm->addFilter($this->getFilter('secure'));
    }
}
