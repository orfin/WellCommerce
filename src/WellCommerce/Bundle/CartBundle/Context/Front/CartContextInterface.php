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
    public function setCurrentCart(CartInterface $cart);

    public function getCurrentCart() : CartInterface;

    public function getCurrentCartIdentifier() : int;

    public function hasCurrentCart() : bool;
}
