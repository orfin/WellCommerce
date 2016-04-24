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

namespace WellCommerce\Bundle\CartBundle\Manager\Front;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartModifierInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;

/**
 * Class CartModifierManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartModifierManager extends AbstractFrontManager implements CartModifierManagerInterface
{
    public function getCartModifier(CartInterface $cart, string $name) : CartModifierInterface
    {
        if (false === $cart->hasModifier($name)) {
            return $this->createCartModifier($cart, $name);
        }
        
        return $cart->getModifier($name);
    }

    private function createCartModifier(CartInterface $cart, string $name): CartModifierInterface
    {
        $modifier = $this->getDefaultCartModifier($name);
        $modifier->setCart($cart);

        return $modifier;
    }
    
    private function getDefaultCartModifier(string $name) : CartModifierInterface
    {
        return $this->get('cart.modifier.collection')->get($name);
    }
}
