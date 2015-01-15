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
namespace WellCommerce\Bundle\PaymentBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class PaymentMethodForm
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $languageData = $requiredData->addChild($this->getElement('language_fieldset', [
            'name'  => 'translations',
            'label' => $this->trans('Translations')
        ]));

        $languageData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('Name'),
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'    => 'processor',
            'label'   => $this->trans('Processor'),
            'options' => [],
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('Enabled'),
            'default' => 1
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'    => 'hierarchy',
            'label'   => $this->trans('Hierarchy'),
            'default' => 0
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
