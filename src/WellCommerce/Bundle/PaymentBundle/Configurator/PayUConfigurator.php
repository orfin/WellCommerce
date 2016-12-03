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
 * Class PayUConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PayUConfigurator extends AbstractPaymentMethodConfigurator
{
    public function getName() : string
    {
        return 'payu';
    }

    public function getInitializeTemplateName() : string
    {
        return 'WellCommercePaymentBundle:Front/PayU:initialize.html.twig';
    }

    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency)
    {
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getConfigurationKey('merchant_pos_id'),
            'label'        => $this->trans('merchant_pos_id'),
            'dependencies' => [$dependency]
        ]));
    
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getConfigurationKey('signature_key'),
            'label'        => $this->trans('signature_key'),
            'dependencies' => [$dependency]
        ]));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setAllowedTypes($this->getConfigurationKey('merchant_pos_id'), 'string');
        $resolver->setAllowedTypes($this->getConfigurationKey('signature_key'), 'string');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSupportedConfigurationKeys() : array
    {
        return [
            $this->getConfigurationKey('merchant_pos_id'),
            $this->getConfigurationKey('signature_key'),
        ];
    }
}
