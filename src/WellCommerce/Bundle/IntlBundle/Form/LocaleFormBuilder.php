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
namespace WellCommerce\Bundle\IntlBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class LocaleFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.label.required')
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'    => 'code',
            'label'   => $this->trans('locale.label.code'),
            'options' => $this->get('locale.repository')->getLocaleNames()
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'currency',
            'label'       => $this->trans('locale.label.currency'),
            'options'     => $this->get('currency.collection')->getSelect([
                'value_key' => 'id',
                'label_key' => 'code',
                'order_by'  => 'code'
            ]),
            'transformer' => new EntityToIdentifierTransformer($this->get('currency.repository'))
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
