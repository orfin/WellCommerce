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

namespace WellCommerce\Bundle\OrderBundle\Repository;

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Class CartRepository
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartRepository extends EntityRepository implements CartRepositoryInterface
{
    public function findCart(ClientInterface $client = null, $sessionId, ShopInterface $shop)
    {
        if (null !== $client) {
            $cart = $this->getCartForClient($client, $shop);
            if (null === $cart) {
                $cart = $this->getCartBySessionId($sessionId, $shop);
            }
        } else {
            $cart = $this->getCartBySessionId($sessionId, $shop);
        }
        
        return $cart;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCartForClient(ClientInterface $client, ShopInterface $shop)
    {
        return $this->findOneBy([
            'client' => $client,
            'shop'   => $shop
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCartBySessionId($sessionId, ShopInterface $shop)
    {
        return $this->findOneBy([
            'sessionId' => $sessionId,
            'shop'      => $shop
        ]);
    }
}
