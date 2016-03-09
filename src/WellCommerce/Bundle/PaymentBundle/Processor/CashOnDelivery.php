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

namespace WellCommerce\Bundle\PaymentBundle\Processor;

use WellCommerce\Component\Form\Dependencies\DependencyInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class CashOnDelivery
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CashOnDelivery extends AbstractPaymentProcessor
{
    /**
     * @var string
     */
    protected $name = 'Cash on delivery';

    /**
     * @var string
     */
    protected $alias = 'cod';

    /**
     * {@inheritdoc}
     */
    public function addConfigurationFields(FormBuilderInterface $builder, ElementInterface $fieldset, DependencyInterface $dependency)
    {
        $fieldset->addChild($builder->getElement('tip', [
            'tip'          => $this->trans('payment_method.cod.configuration'),
            'dependencies' => [$dependency]
        ]));
    }
}
