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

namespace WellCommerce\Bundle\OrderBundle\Manager;

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Manager;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Class OrderManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderManager extends Manager implements OrderManagerInterface
{
    public function findOrder(string $currency, string $sessionId, ClientInterface $client = null, ShopInterface $shop) : OrderInterface
    {
        $order = $this->findCurrentOrder($client, $sessionId, $shop);

        if (!$order instanceof OrderInterface) {
            /** @var OrderInterface $order */
            $order = $this->initResource();
            $order->setClient($client);
            $order->setSessionId($sessionId);
            $order->setShop($shop);
            $this->createResource($order);
        }

        if ($this->isOrderDirty($order, $currency, $client)) {
            $order->setCurrency($currency);
            $order->setClient($client);
            $this->updateResource($order);
        }

        return $order;
    }

    private function isOrderDirty(OrderInterface $order, string $currency, ClientInterface $client = null) : bool
    {
        return $order->getClient() !== $client || $order->getCurrency() !== $currency;
    }

    private function findCurrentOrder(ClientInterface $client = null, $sessionId, ShopInterface $shop)
    {
        if (null !== $client) {
            $order = $this->getCurrentClientOrder($client, $shop);
            if (null === $order) {
                $order = $this->getCurrentSessionOrder($sessionId, $shop);
            }
        } else {
            $order = $this->getCurrentSessionOrder($sessionId, $shop);
        }

        return $order;
    }

    private function getCurrentClientOrder(ClientInterface $client, ShopInterface $shop)
    {
        return $this->getRepository()->findOneBy([
            'client'    => $client,
            'shop'      => $shop,
            'confirmed' => false
        ]);
    }

    private function getCurrentSessionOrder($sessionId, ShopInterface $shop)
    {
        return $this->getRepository()->findOneBy([
            'sessionId' => $sessionId,
            'shop'      => $shop,
            'confirmed' => false
        ]);
    }
}
