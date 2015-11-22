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
namespace WellCommerce\CommonBundle\Form\Admin;

use WellCommerce\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

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
            'label' => $this->trans('common.fieldset.general')
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'    => 'code',
            'label'   => $this->trans('locale.label.code'),
            'options' => $this->get('locale.repository')->getLocaleNames()
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'currency',
            'label'       => $this->trans('locale.label.currency'),
            'options'     => $this->get('currency.dataset.admin')->getResult('select', [], ['label_column' => 'code']),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('currency.repository'))
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
