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
namespace WellCommerce\Bundle\MultiStoreBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class ShopFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data')
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('shop.label.name'),
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'company',
            'label'       => $this->trans('shop.label.company'),
            'options'     => $this->get('company.collection')->getSelect(),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('company.repository'))
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'theme',
            'label'       => $this->trans('shop.label.theme'),
            'options'     => $this->get('theme.collection')->getSelect(),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('theme.repository'))
        ]));

        $urlData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'url_data',
            'label' => $this->trans('shop.fieldset.url_data')
        ]));

        $urlData->addChild($this->getElement('text_field', [
            'name'  => 'url',
            'label' => $this->trans('shop.label.url'),
        ]));

        $cartSettings = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'cart_settings',
            'label' => $this->trans('shop.cart_settings.label')
        ]));

        $cartSettings->addChild($this->getElement('select', [
            'name'        => 'defaultOrderStatus',
            'label'       => $this->trans('shop.label.default_order_status'),
            'options'     => $this->get('order_status.collection')->getSelect(),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('order_status.repository'))
        ]));

        $cartSettings->addChild($this->getElement('select', [
            'name'    => 'defaultCountry',
            'label'   => $this->trans('shop.label.default_country'),
            'options' => $this->get('country.repository')->all()
        ]));
        
        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
