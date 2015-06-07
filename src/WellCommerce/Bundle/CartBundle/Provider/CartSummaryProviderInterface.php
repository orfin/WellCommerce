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

namespace WellCommerce\Bundle\CartBundle\Provider;

use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;

/**
 * Interface CartSummaryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartSummaryProviderInterface extends ProviderInterface
{
    /**
     * @return Cart
     */
    public function getCart();

    /**
     * @param Cart $cart
     */
    public function setCart(Cart $cart);

}