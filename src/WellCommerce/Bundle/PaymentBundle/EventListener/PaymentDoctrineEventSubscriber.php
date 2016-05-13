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
use Doctrine\ORM\Id\UuidGenerator;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Manager\PaymentStateHistoryManagerInterface;

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
            'prePersist',
            'postPersist',
            'postUpdate',
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof PaymentInterface) {
            $generator = new UuidGenerator();
            $token     = $generator->generate($args->getObjectManager(), null);
            $entity->setToken($token);
        }
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

    protected function getPaymentStateHistoryManager() : PaymentStateHistoryManagerInterface
    {
        return $this->container->get('payment_state_history.manager');
    }
}
