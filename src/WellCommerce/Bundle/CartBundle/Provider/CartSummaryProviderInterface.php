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
     * @param Cart $cart
     */
    public function setCart(Cart $cart);

    /**
     * Returns total quantity
     *
     * @return float
     */
    public function getQuantity();

    /**
     * Returns total weight
     *
     * @return float
     */
    public function getWeight();

    /**
     * Returns converted total cart price
     *
     * @return float
     */
    public function getPrice();

    /**
     * @return array
     */
    public function getTotals();
}