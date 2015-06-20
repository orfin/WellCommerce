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
use WellCommerce\Bundle\FormBundle\Conditions\Equals;
use WellCommerce\Bundle\FormBundle\Event\FormEvent;

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
            'shipping_method.form.init' => 'onShippingMethodFormInit',
        ];
    }

    /**
     * Adds processor settings to shipping method form
     *
     * @param FormEvent $event
     */
    public function onShippingMethodFormInit(FormEvent $event)
    {
        $builder         = $event->getFormBuilder();
        $form            = $builder->getForm();
        $resource        = $builder->getData();
        $processors      = $this->container->get('shipping_method.processor.collection')->all();
        $processorSelect = $form->getChild('required_data')->getChild('processor');

        /**
         * @var $processor \WellCommerce\Bundle\ShippingBundle\Processor\ShippingMethodProcessorInterface
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
