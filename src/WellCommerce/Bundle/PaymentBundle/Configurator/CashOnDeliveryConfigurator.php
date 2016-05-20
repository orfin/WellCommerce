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

use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class CashOnDeliveryConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CashOnDeliveryConfigurator extends AbstractPaymentMethodConfigurator
{
    public function getName() : string
    {
        return 'cash_on_delivery';
    }
    
    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency)
    {
        $fieldset->addChild($builder->getElement('tip', [
            'tip'          => $this->trans('payment_method.cod.configuration'),
            'dependencies' => [$dependency]
        ]));
    }
}
