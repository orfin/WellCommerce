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

use WellCommerce\Bundle\AppBundle\Entity\CartInterface;

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
     * @return null|CartInterface
     */
    public function getCurrentCart();

    /**
     * @return int|null
     */
    public function getCurrentCartIdentifier();

    /**
     * @return bool
     */
    public function hasCurrentCart();
}
