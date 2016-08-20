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
namespace WellCommerce\Bundle\OrderBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WellCommerce\Bundle\CoreBundle\Event\EntityEvent;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorTraverser;

/**
 * Class OrderSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderSubscriber implements EventSubscriberInterface
{
    /**
     * @var OrderVisitorTraverser
     */
    private $orderVisitorTraverser;
    
    /**
     * OrderSubscriber constructor.
     *
     * @param OrderVisitorTraverser $orderVisitorTraverser
     */
    public function __construct(OrderVisitorTraverser $orderVisitorTraverser)
    {
        $this->orderVisitorTraverser = $orderVisitorTraverser;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            'order.pre_create' => ['onOrderChangedEvent', 0],
            'order.pre_update' => ['onOrderChangedEvent', 0],
        ];
    }
    
    public function onOrderChangedEvent(EntityEvent $event)
    {
        $order = $event->getEntity();
        if ($order instanceof OrderInterface) {
            $this->orderVisitorTraverser->traverse($order);
        }
    }
}
