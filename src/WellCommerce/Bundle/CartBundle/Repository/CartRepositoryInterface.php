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

namespace WellCommerce\Bundle\CartBundle\Repository;

use WellCommerce\Bundle\ClientBundle\Entity\Client;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\DataSetAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;

/**
 * Interface CartRepositoryInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartRepositoryInterface extends RepositoryInterface, DataSetAwareRepositoryInterface
{
    /**
     * Returns client cart
     *
     * @param Client $client
     * @param Shop   $shop
     *
     * @return null|\WellCommerce\Bundle\CartBundle\Entity\Cart
     */
    public function getCartForClient(Client $client, Shop $shop);

    /**
     * Returns cart by session identifier
     *
     * @param string $sessionId
     * @param Shop   $shop
     *
     * @return null|\WellCommerce\Bundle\CartBundle\Entity\Cart
     */
    public function getCartBySessionId($sessionId, Shop $shop);

    /**
     * Returns current cart by session identifier or by client
     *
     * @param Client $client
     * @param        $sessionId
     * @param Shop   $shop
     *
     * @return null|\WellCommerce\Bundle\CartBundle\Entity\Cart
     */
    public function getCart(Client $client = null, $sessionId, Shop $shop);
}
