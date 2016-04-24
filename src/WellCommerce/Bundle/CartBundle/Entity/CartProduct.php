<?php

namespace WellCommerce\Bundle\CartBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\VariantAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Class CartProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProduct extends AbstractEntity implements CartProductInterface
{
    use TimestampableTrait;
    use ProductAwareTrait;
    use VariantAwareTrait;
    use CartAwareTrait;
    
    protected $quantity;
    protected $options;

    public function getQuantity() : int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function increaseQuantity(int $increase)
    {
        $this->quantity += $increase;
    }

    public function decreaseQuantity(int $decrease)
    {
        $this->quantity -= $decrease;
    }

    public function getSellPrice() : DiscountablePrice
    {
        if ($this->variant instanceof VariantInterface) {
            return $this->variant->getSellPrice();
        }

        return $this->product->getSellPrice();
    }

    public function getWeight() : float
    {
        if ($this->variant instanceof VariantInterface) {
            return $this->variant->getWeight();
        }

        return $this->product->getWeight();
    }

    public function getOptions() : array
    {
        return $this->options;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }
}
