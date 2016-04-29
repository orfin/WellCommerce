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
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Interface CartRepositoryInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns the cart for client or for session identifier
     *
     * @param ClientInterface|null $client
     * @param string               $sessionId
     * @param ShopInterface        $shop
     *
     * @return null|\WellCommerce\Bundle\OrderBundle\Entity\CartInterface
     */
    public function findCart(ClientInterface $client = null, $sessionId, ShopInterface $shop);

    /**
     * Returns client cart
     *
     * @param ClientInterface $client
     * @param ShopInterface   $shop
     *
     * @return null|\WellCommerce\Bundle\OrderBundle\Entity\CartInterface
     */
    public function getCartForClient(ClientInterface $client, ShopInterface $shop);

    /**
     * Returns cart by session identifier
     *
     * @param string        $sessionId
     * @param ShopInterface $shop
     *
     * @return null|\WellCommerce\Bundle\OrderBundle\Entity\CartInterface
     */
    public function getCartBySessionId($sessionId, ShopInterface $shop);
}
