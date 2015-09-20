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

namespace WellCommerce\Bundle\CartBundle\Calculator;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorInterface;

/**
 * Class CartCalculatorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartCalculatorInterface extends CartVisitorInterface
{
    /**
     * @param CartInterface $cart
     *
     * @return int|float
     */
    public function calculate(CartInterface $cart);
}
