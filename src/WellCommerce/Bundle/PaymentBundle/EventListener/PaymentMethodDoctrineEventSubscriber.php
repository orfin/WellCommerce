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

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorCollection;
use WellCommerce\Bundle\PaymentBundle\Processor\PaymentProcessorInterface;

/**
 * Class PaymentMethodDoctrineEventSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodDoctrineEventSubscriber implements EventSubscriber
{
    use ContainerAwareTrait;

    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }
    
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->onPaymentMethodBeforeSave($args);
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->onPaymentMethodBeforeSave($args);
    }
    
    public function onPaymentMethodBeforeSave(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof PaymentMethodInterface) {
            $processor = $this->getPaymentProcessorCollection()->get($entity->getProcessor());
            $entity->setConfiguration($this->filterConfiguration($entity->getConfiguration(), $processor));
        }
    }
    
    protected function filterConfiguration(array $configuration, PaymentProcessorInterface $processor) : array
    {
        $supportedConfigurationKeys = $processor->getConfigurator()->getSupportedConfigurationKeys();

        return array_filter($configuration, function ($k) use ($supportedConfigurationKeys) {
            return in_array($k, $supportedConfigurationKeys);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getPaymentProcessorCollection() : PaymentProcessorCollection
    {
        return $this->container->get('payment.processor.collection');
    }
}
