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
 * Class CartTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartTransformer
{
    private $cartProductTransformer;

    public function __construct(CartProductTransformer $cartProductTransformer)
    {
        $this->cartProductTransformer = $cartProductTransformer;
    }

    public function transformCart(CartInterface $cart, OrderInterface $order)
    {
        
    }
}
