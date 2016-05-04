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
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Security\SecurityHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Event\EntityEvent;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Manager\OrderManagerInterface;
use WellCommerce\Bundle\OrderBundle\Storage\OrderStorageInterface;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorTraverser;
use WellCommerce\Bundle\ShopBundle\Storage\ShopStorageInterface;

/**
 * Class OrderSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestHelperInterface
     */
    private $requestHelper;

    /**
     * @var SecurityHelperInterface
     */
    private $securityHelper;

    /**
     * @var OrderManagerInterface
     */
    private $orderManager;

    /**
     * @var OrderStorageInterface
     */
    private $orderStorage;

    /**
     * @var ShopStorageInterface
     */
    private $shopStorage;

    /**
     * @var OrderVisitorTraverser
     */
    private $orderVisitorTraverser;

    /**
     * OrderSubscriber constructor.
     *
     * @param RequestHelperInterface  $requestHelper
     * @param SecurityHelperInterface $securityHelper
     * @param OrderManagerInterface   $orderManager
     * @param OrderStorageInterface   $orderStorage
     * @param ShopStorageInterface    $shopStorage
     * @param OrderVisitorTraverser   $orderVisitorTraverser
     */
    public function __construct(
        RequestHelperInterface $requestHelper,
        SecurityHelperInterface $securityHelper,
        OrderManagerInterface $orderManager,
        OrderStorageInterface $orderStorage,
        ShopStorageInterface $shopStorage,
        OrderVisitorTraverser $orderVisitorTraverser
    ) {
        $this->requestHelper         = $requestHelper;
        $this->securityHelper        = $securityHelper;
        $this->orderManager          = $orderManager;
        $this->orderStorage          = $orderStorage;
        $this->shopStorage           = $shopStorage;
        $this->orderVisitorTraverser = $orderVisitorTraverser;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -150],
            'order.pre_create'       => ['onOrderChangedEvent', 0],
            'order.pre_update'       => ['onOrderChangedEvent', 0],
        ];
    }
    
    public function onKernelController()
    {
        if (false === $this->securityHelper->isActiveAdminFirewall()) {
            $currency  = $this->requestHelper->getCurrentCurrency();
            $sessionId = $this->requestHelper->getSessionId();
            $client    = $this->securityHelper->getCurrentClient();
            $shop      = $this->shopStorage->getCurrentShop();
            $order     = $this->orderManager->findOrder($sessionId, $client, $shop);

            if ($this->isOrderDirty($order, $currency, $client)) {
                $order->setCurrency($currency);
                $order->setClient($client);
                $this->orderManager->updateResource($order);
            }

            $this->orderStorage->setCurrentOrder($order);
        }
    }

    public function onOrderChangedEvent(EntityEvent $event)
    {
        $this->orderVisitorTraverser->traverse($event->getEntity());
    }
    
    private function isOrderDirty(OrderInterface $order, string $currency, ClientInterface $client = null) : bool
    {
        return $order->getClient() !== $client || $order->getCurrency() !== $currency;
    }
}
