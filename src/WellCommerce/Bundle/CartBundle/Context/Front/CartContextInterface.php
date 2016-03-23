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

namespace WellCommerce\Bundle\CartBundle\Context\Front;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;

/**
 * Interface CartContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartContextInterface
{
    /**
     * @param CartInterface $cart
     */
    public function setCurrentCart(CartInterface $cart);

    /**
     * @return CartInterface
     */
    public function getCurrentCart() : CartInterface;

    /**
     * @return int
     */
    public function getCurrentCartIdentifier() : int;

    /**
     * @return bool
     */
    public function hasCurrentCart() : bool;
}
