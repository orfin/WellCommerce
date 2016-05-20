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

namespace WellCommerce\Bundle\PaymentBundle\Configurator;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class PayPalConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PayPalConfigurator extends AbstractPaymentMethodConfigurator
{
    public function getName() : string
    {
        return 'paypal';
    }

    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency)
    {
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getConfigurationKey('client_id'),
            'label'        => $this->trans('paypal.label.client_id'),
            'dependencies' => [$dependency]
        ]));

        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getConfigurationKey('client_secret'),
            'label'        => $this->trans('paypal.label.client_secret'),
            'dependencies' => [$dependency]
        ]));

        $fieldset->addChild($builder->getElement('select', [
            'name'         => $this->getConfigurationKey('mode'),
            'label'        => $this->trans('paypal.label.mode'),
            'options'      => [
                'live'    => 'live',
                'sandbox' => 'sandbox'
            ],
            'dependencies' => [$dependency]
        ]));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setAllowedTypes($this->getConfigurationKey('client_id'), 'string');
        $resolver->setAllowedTypes($this->getConfigurationKey('client_secret'), 'string');
        $resolver->setAllowedTypes($this->getConfigurationKey('mode'), 'string');

        $resolver->setAllowedValues($this->getConfigurationKey('mode'), ['sandbox', 'live']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSupportedConfigurationKeys() : array
    {
        return [
            $this->getConfigurationKey('client_id'),
            $this->getConfigurationKey('client_secret'),
            $this->getConfigurationKey('mode')
        ];
    }
}
