<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\PriceInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProduct;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Class CartProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProduct extends OrderProduct implements CartProductInterface
{
    public function getSellPrice() : PriceInterface
    {
        if ($this->variant instanceof VariantInterface) {
            return $this->variant->getSellPrice();
        }

        return $this->product->getSellPrice();
    }
}
