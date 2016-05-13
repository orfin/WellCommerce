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
 * Class BankTransferConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class BankTransferConfigurator extends AbstractPaymentMethodConfigurator
{
    public function getName() : string
    {
        return 'bank_transfer';
    }

    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency)
    {
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getConfigurationKey('account_number'),
            'label'        => $this->trans('payment_method.bank_transfer.account_number'),
            'dependencies' => [$dependency]
        ]));

        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getConfigurationKey('account_owner'),
            'label'        => $this->trans('payment_method.bank_transfer.account_owner'),
            'dependencies' => [$dependency]
        ]));
        
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getConfigurationKey('sort_number'),
            'label'        => $this->trans('payment_method.bank_transfer.sort_number'),
            'dependencies' => [$dependency]
        ]));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setAllowedTypes($this->getConfigurationKey('account_number'), 'string');
        $resolver->setAllowedTypes($this->getConfigurationKey('account_owner'), 'string');
        $resolver->setAllowedTypes($this->getConfigurationKey('sort_number'), 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedConfigurationKeys() : array
    {
        return [
            $this->getConfigurationKey('account_number'),
            $this->getConfigurationKey('account_owner'),
            $this->getConfigurationKey('sort_number')
        ];
    }
}
