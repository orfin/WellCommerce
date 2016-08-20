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
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;
use WellCommerce\Bundle\OrderBundle\Repository\OrderStatusGroupRepositoryInterface;

/**
 * Class OrderStatusSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderStatusSubscriber implements EventSubscriberInterface
{
    /**
     * @var OrderStatusGroupRepositoryInterface
     */
    private $orderStatusGroupRepository;
    
    /**
     * OrderStatusSubscriber constructor.
     *
     * @param OrderStatusGroupRepositoryInterface $orderStatusGroupRepository
     */
    public function __construct(OrderStatusGroupRepositoryInterface $orderStatusGroupRepository)
    {
        $this->orderStatusGroupRepository = $orderStatusGroupRepository;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            'order_status.post_init' => ['onOrderStatusPostInit', 0],
        ];
    }
    
    public function onOrderStatusPostInit(EntityEvent $event)
    {
        $orderStatus = $event->getEntity();
        if ($orderStatus instanceof OrderStatusInterface) {
            $orderStatus->setOrderStatusGroup($this->orderStatusGroupRepository->findOneBy([]));
        }
    }
}
