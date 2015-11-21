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

namespace WellCommerce\SalesBundle\Visitor;

use WellCommerce\SalesBundle\Entity\CartInterface;

/**
 * Interface CartVisitorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartVisitorInterface
{
    /**
     * @param CartInterface $cart
     */
    public function visitCart(CartInterface $cart);

    /**
     * @return int
     */
    public function getPriority();

    /**
     * @return string
     */
    public function getAlias();
}
