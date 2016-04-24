<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\PriceInterface;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\VariantAwareTrait;

/**
 * Class OrderProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProduct extends AbstractEntity implements OrderProductInterface
{
    use TimestampableTrait;
    use ProductAwareTrait;
    use VariantAwareTrait;
    use OrderAwareTrait;

    protected $quantity;
    protected $buyPrice;
    protected $sellPrice;
    protected $weight;
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

    public function getSellPrice() : PriceInterface
    {
        return $this->sellPrice;
    }

    public function setSellPrice(PriceInterface $sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }

    public function getBuyPrice() : PriceInterface
    {
        return $this->buyPrice;
    }

    public function setBuyPrice(PriceInterface $buyPrice)
    {
        $this->buyPrice = $buyPrice;
    }

    public function getWeight() : float
    {
        return $this->weight;
    }

    public function setWeight(float $weight)
    {
        $this->weight = $weight;
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
