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

namespace WellCommerce\Bundle\CartBundle\Factory;

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopInterface;

/**
 * Interface CartFactoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartFactoryInterface extends FactoryInterface
{
    /**
     * Creates the cart object
     *
     * @param ClientInterface|null $client
     * @param ShopInterface        $shop
     * @param string               $sessionId
     *
     * @return \WellCommerce\Bundle\CartBundle\Entity\CartInterface
     */
    public function createCart(ClientInterface $client = null, ShopInterface $shop, $sessionId);
}
