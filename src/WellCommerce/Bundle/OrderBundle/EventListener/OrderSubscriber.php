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
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Security\SecurityHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Manager\OrderManagerInterface;
use WellCommerce\Bundle\OrderBundle\Storage\OrderStorageInterface;
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
     * OrderSubscriber constructor.
     *
     * @param RequestHelperInterface  $requestHelper
     * @param SecurityHelperInterface $securityHelper
     * @param OrderManagerInterface   $orderManager
     * @param OrderStorageInterface   $orderStorage
     * @param ShopStorageInterface    $shopStorage
     */
    public function __construct(
        RequestHelperInterface $requestHelper,
        SecurityHelperInterface $securityHelper,
        OrderManagerInterface $orderManager,
        OrderStorageInterface $orderStorage,
        ShopStorageInterface $shopStorage
    ) {
        $this->requestHelper  = $requestHelper;
        $this->securityHelper = $securityHelper;
        $this->orderManager   = $orderManager;
        $this->orderStorage   = $orderStorage;
        $this->shopStorage    = $shopStorage;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -150],
        ];
    }
    
    public function onKernelController()
    {
        if (false === $this->securityHelper->isActiveAdminFirewall()) {
            $currency  = $this->requestHelper->getCurrentCurrency();
            $sessionId = $this->requestHelper->getSessionId();
            $client    = $this->securityHelper->getCurrentClient();
            $shop      = $this->shopStorage->getCurrentShop();
            $order     = $this->orderManager->findOrder($currency, $sessionId, $client, $shop);

            $this->orderStorage->setCurrentOrder($order);
        }
    }
}
