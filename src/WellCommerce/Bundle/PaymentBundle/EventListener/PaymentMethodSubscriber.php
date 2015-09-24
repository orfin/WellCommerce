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
use WellCommerce\Bundle\FormBundle\Conditions\Equals;
use WellCommerce\Bundle\FormBundle\Event\FormEvent;

/**
 * Class PaymentMethodSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
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
        $builder          = $event->getFormBuilder();
        $form             = $event->getForm();
        $resource         = $form->getModelData();
        $processors       = $this->container->get('payment_method.processor.collection')->all();
        $calculatorSelect = $form->getChildren()->get('required_data');

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
