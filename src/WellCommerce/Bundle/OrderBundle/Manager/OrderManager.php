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
use WellCommerce\Bundle\DoctrineBundle\Manager\Manager;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Class OrderManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderManager extends Manager implements OrderManagerInterface
{
    public function getOrder(string $sessionId, ClientInterface $client = null, ShopInterface $shop, string $currency) : OrderInterface
    {
        $order = $this->findOrder($sessionId, $client, $shop);

        if (!$order instanceof OrderInterface) {
            /** @var OrderInterface $order */
            $order = $this->initResource();
            $this->createResource($order);
        }

        if ($this->isOrderDirty($order, $currency, $client, $sessionId)) {
            $order->setCurrency($currency);
            $order->setClient($client);
            $order->setSessionId($sessionId);
            $this->updateResource($order);
        }

        return $order;
    }

    public function findOrder(string $sessionId, ClientInterface $client = null, ShopInterface $shop)
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

    private function isOrderDirty(OrderInterface $order, string $currency, ClientInterface $client = null, string $sessionId) : bool
    {
        return $order->getClient() !== $client || $order->getCurrency() !== $currency || $order->getSessionId() !== $sessionId;
    }
}
