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
 * Class Przelewy24Configurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class Przelewy24Configurator extends AbstractPaymentMethodConfigurator
{
    public function getName() : string
    {
        return 'przelewy24';
    }
    
    public function getInitializeTemplateName() : string
    {
        return 'WellCommercePaymentBundle:Front/Przelewy24:initialize.html.twig';
    }
    
    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency)
    {
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getConfigurationKey('merchant_id'),
            'label'        => $this->trans('merchant_id'),
            'dependencies' => [$dependency],
        ]));
        
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getConfigurationKey('pos_id'),
            'label'        => $this->trans('pos_id'),
            'dependencies' => [$dependency],
        ]));
    
        $fieldset->addChild($builder->getElement('text_field', [
            'name'         => $this->getConfigurationKey('crc'),
            'label'        => $this->trans('crc'),
            'dependencies' => [$dependency],
        ]));
        
        $fieldset->addChild($builder->getElement('select', [
            'name'         => $this->getConfigurationKey('test_mode'),
            'label'        => $this->trans('test_mode'),
            'options'      => [
                0 => 0,
                1 => 1,
            ],
            'dependencies' => [$dependency],
        ]));
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        $resolver->setAllowedTypes($this->getConfigurationKey('merchant_id'), 'string');
        $resolver->setAllowedTypes($this->getConfigurationKey('pos_id'), 'string');
        $resolver->setAllowedTypes($this->getConfigurationKey('crc'), 'string');
        $resolver->setAllowedTypes($this->getConfigurationKey('test_mode'), 'int');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSupportedConfigurationKeys() : array
    {
        return [
            $this->getConfigurationKey('merchant_id'),
            $this->getConfigurationKey('pos_id'),
            $this->getConfigurationKey('crc'),
            $this->getConfigurationKey('test_mode'),
        ];
    }
}
