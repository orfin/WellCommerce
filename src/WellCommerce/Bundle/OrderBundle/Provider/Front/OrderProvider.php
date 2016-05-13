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

namespace WellCommerce\Bundle\OrderBundle\Provider\Front;

use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Security\SecurityHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Manager\OrderManagerInterface;
use WellCommerce\Bundle\ShopBundle\Storage\ShopStorageInterface;

/**
 * Class OrderProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderProvider implements OrderProviderInterface
{
    /**
     * @var OrderInterface
     */
    private $currentOrder;
    
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
     * @var ShopStorageInterface
     */
    private $shopStorage;
    
    /**
     * OrderSubscriber constructor.
     *
     * @param RequestHelperInterface  $requestHelper
     * @param SecurityHelperInterface $securityHelper
     * @param OrderManagerInterface   $orderManager
     * @param ShopStorageInterface    $shopStorage
     */
    public function __construct(
        RequestHelperInterface $requestHelper,
        SecurityHelperInterface $securityHelper,
        OrderManagerInterface $orderManager,
        ShopStorageInterface $shopStorage
    ) {
        $this->requestHelper  = $requestHelper;
        $this->securityHelper = $securityHelper;
        $this->orderManager   = $orderManager;
        $this->shopStorage    = $shopStorage;
    }
    
    public function getCurrentOrder() : OrderInterface
    {
        if (null === $this->currentOrder) {
            $currency           = $this->requestHelper->getCurrentCurrency();
            $sessionId          = $this->requestHelper->getSessionId();
            $client             = $this->securityHelper->getCurrentClient();
            $shop               = $this->shopStorage->getCurrentShop();
            $this->currentOrder = $this->orderManager->getOrder($sessionId, $client, $shop, $currency);
        }

        return $this->currentOrder;
    }

    public function getCurrentOrderIdentifier() : int
    {
        if ($this->hasCurrentOrder()) {
            return $this->getCurrentOrder()->getId();
        }

        return 0;
    }

    public function hasCurrentOrder() : bool
    {
        $order = $this->findCurrentOrder();
        
        return $order instanceof OrderInterface;
    }

    private function findCurrentOrder()
    {
        $sessionId = $this->requestHelper->getSessionId();
        $client    = $this->securityHelper->getCurrentClient();
        $shop      = $this->shopStorage->getCurrentShop();

        return $this->orderManager->findOrder($sessionId, $client, $shop);
    }
}
