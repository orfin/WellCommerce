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
namespace WellCommerce\Bundle\PaymentBundle\EventListener;

use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\CoreBundle\Form\Conditions\Equals;
use WellCommerce\Bundle\CoreBundle\Form\Event\FormEvent;

/**
 * Class PaymentMethodSubscriber
 *
 * @package WellCommerce\Bundle\PaymentBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return parent::getSubscribedEvents() + [
            'payment_method.form.init' => 'onPaymentMethodFormInit',
        ];
    }

    /**
     * Adds processor settings to payment method form
     *
     * @param FormEvent $event
     */
    public function onPaymentMethodFormInit(FormEvent $event)
    {
        $builder         = $event->getFormBuilder();
        $form            = $builder->getForm();
        $resource        = $builder->getData();
        $processors      = $this->container->get('payment_method.processor.collection')->all();
        $processorSelect = $form->getChild('required_data')->getChild('processor');

        /**
         * @var $processor \WellCommerce\Bundle\PaymentBundle\Processor\PaymentMethodProcessorInterface
         */
        foreach ($processors as $processor) {
            $processorSelect->addOption($processor->getAlias(), $processor->getName());
            $fieldset = $processor->addConfigurationFieldset($builder, $form, $resource);
            $fieldset->addDependency('show', [
                'field'     => $processorSelect,
                'form'      => $form,
                'condition' => new Equals($processor->getAlias())
            ]);
        }
    }
}