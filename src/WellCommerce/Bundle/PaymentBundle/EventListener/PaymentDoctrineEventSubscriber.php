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
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentStateHistoryManager;

/**
 * Class PaymentDoctrineEventSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentDoctrineEventSubscriber implements EventSubscriber
{
    use ContainerAwareTrait;

    public function getSubscribedEvents()
    {
        return [
            'postPersist',
            'postUpdate',
        ];
    }
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->onPaymentBeforeSave($args);
    }
    
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->onPaymentBeforeSave($args);
    }
    
    public function onPaymentBeforeSave(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof PaymentInterface) {
            $this->getPaymentStateHistoryManager()->createPaymentStateHistory($entity);
        }
    }
    
    protected function getPaymentStateHistoryManager() : PaymentStateHistoryManager
    {
        return $this->container->get('payment_state_history.manager.front');
    }
}
