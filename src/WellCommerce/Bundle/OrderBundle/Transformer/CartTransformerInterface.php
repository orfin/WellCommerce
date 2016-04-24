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

namespace WellCommerce\Bundle\OrderBundle\Transformer;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Interface CartTransformerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartTransformerInterface
{
    public function transformCart(CartInterface $cart, OrderInterface $order);
}
