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

namespace WellCommerce\Bundle\PaymentBundle\Processor\PayPal;

use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\Elements\Fieldset;
use WellCommerce\Bundle\PaymentBundle\Processor\AbstractPaymentProcessor;

/**
 * Class PayPalProcessor
 *
 * @package WellCommerce\Bundle\PaymentBundle\Processor\PayPal
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PayPalProcessor extends AbstractPaymentProcessor
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->trans('PayPal');
    }

    public function addFields(FormBuilderInterface $builder, Fieldset $fieldset)
    {
        $fieldset->addChild($builder->getElement('text_field', [
            'name'  => 'business',
            'label' => $this->trans('E-mail address'),
        ]));

        $fieldset->addChild($builder->getElement('text_field', [
            'name'  => 'username',
            'label' => $this->trans('API Username'),
        ]));

        $fieldset->addChild($builder->getElement('password', [
            'name'  => 'password',
            'label' => $this->trans('API Password'),
        ]));

        $fieldset->addChild($builder->getElement('text_field', [
            'name'  => 'signature',
            'label' => $this->trans('API Signature'),
        ]));

        $fieldset->addChild($builder->getElement('checkbox', [
            'name'  => 'sandbox',
            'label' => $this->trans('Sandbox'),
        ]));
    }
} 