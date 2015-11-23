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

namespace WellCommerce\AppBundle\Visitor;

use WellCommerce\AppBundle\Entity\CartInterface;

/**
 * Interface CartVisitorTraverserInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartVisitorTraverserInterface
{
    /**
     * @param CartInterface $cart
     */
    public function traverse(CartInterface $cart);
}
