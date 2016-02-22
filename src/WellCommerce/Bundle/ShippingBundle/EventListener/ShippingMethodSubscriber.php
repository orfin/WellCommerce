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
namespace WellCommerce\Bundle\ShippingBundle\EventListener;

use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Event\FormEvent;

/**
 * Class ShippingMethodSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            'shipping_method.form_init' => 'onShippingMethodFormInit',
        ];
    }

    /**
     * Adds processor settings to shipping method form
     *
     * @param FormEvent $event
     */
    public function onShippingMethodFormInit(FormEvent $event)
    {
        $form                 = $event->getForm();
        $calculators          = $this->getCalculators();
        $calculatorTypeSelect = $this->getCalculatorTypeElement($form);

        foreach ($calculators as $calculator) {
            $calculatorTypeSelect->addOptionToSelect($calculator->getAlias(), $calculator->getName());
        }
    }

    /**
     * Returns shipping method calculators as a select
     *
     * @return array|\WellCommerce\Bundle\ShippingBundle\Calculator\ShippingMethodCalculatorInterface[]
     */
    protected function getCalculators()
    {
        return $this->container->get('shipping_method.calculator.collection')->all();
    }

    /**
     * Returns calculator select element
     *
     * @param FormInterface $form
     *
     * @return \WellCommerce\Component\Form\Elements\Optioned\Select
     */
    private function getCalculatorTypeElement(FormInterface $form)
    {
        return $form->getChildren()->get('costs_data')->getChildren()->get('calculator');
    }
}
