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

namespace WellCommerce\Bundle\OrderBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

final class OrderSubscriber implements EventSubscriber
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
        $this->traverseOrder($args->getObject());
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->traverseOrder($args->getObject());
    }
    
    private function traverseOrder($order)
    {
        if ($order instanceof OrderInterface) {
            $this->container->get('order.visitor.traverser')->traverse($order);
        }
    }
}
