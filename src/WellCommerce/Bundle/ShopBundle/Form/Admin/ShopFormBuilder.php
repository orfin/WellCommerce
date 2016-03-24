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
namespace WellCommerce\Bundle\ShopBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

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
        $currencies = $this->get('currency.dataset.admin')->getResult('select', ['order_by' => 'code'], [
            'label_column' => 'code',
            'value_column' => 'code'
        ]);

        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'company',
            'label'       => $this->trans('shop.label.company'),
            'options'     => $this->get('company.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('company.repository'))
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'        => 'theme',
            'label'       => $this->trans('shop.label.theme'),
            'options'     => $this->get('theme.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('theme.repository'))
        ]));

        $urlData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'url_data',
            'label' => $this->trans('shop.fieldset.url_configuration')
        ]));

        $urlData->addChild($this->getElement('text_field', [
            'name'  => 'url',
            'label' => $this->trans('shop.label.url'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $cartSettings = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'cart_settings',
            'label' => $this->trans('shop.fieldset.cart_configuration')
        ]));

        $cartSettings->addChild($this->getElement('select', [
            'name'    => 'defaultCountry',
            'label'   => $this->trans('shop.label.default_country'),
            'options' => $this->get('country.repository')->all()
        ]));

        $cartSettings->addChild($this->getElement('select', [
            'name'    => 'defaultCurrency',
            'label'   => $this->trans('shop.label.default_currency'),
            'options' => $currencies,
        ]));

        $cartSettings->addChild($this->getElement('select', [
            'name'        => 'clientGroup',
            'label'       => $this->trans('shop.label.default_client_group'),
            'options'     => $this->get('client_group.dataset.admin')->getResult('select'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('client_group.repository'))
        ]));

        $mailerConfiguration = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'mailer_configuration',
            'label' => $this->trans('shop.fieldset.mailer_configuration')
        ]));

        $mailerConfiguration->addChild($this->getElement('text_field', [
            'name'  => 'mailerConfiguration.from',
            'label' => $this->trans('shop.label.mailer_configuration.from'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $mailerConfiguration->addChild($this->getElement('text_field', [
            'name'  => 'mailerConfiguration.host',
            'label' => $this->trans('shop.label.mailer_configuration.host'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $mailerConfiguration->addChild($this->getElement('text_field', [
            'name'  => 'mailerConfiguration.port',
            'label' => $this->trans('shop.label.mailer_configuration.port'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $mailerConfiguration->addChild($this->getElement('text_field', [
            'name'  => 'mailerConfiguration.user',
            'label' => $this->trans('shop.label.mailer_configuration.user'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $mailerConfiguration->addChild($this->getElement('password', [
            'name'  => 'mailerConfiguration.pass',
            'label' => $this->trans('shop.label.mailer_configuration.pass'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $mailerConfiguration->addChild($this->getElement('password', [
            'name'  => 'mailerConfiguration.pass',
            'label' => $this->trans('shop.label.mailer_configuration.pass'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
