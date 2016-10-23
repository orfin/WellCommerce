<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\DiscountablePriceInterface;
use WellCommerce\Bundle\AppBundle\Entity\PriceInterface;
use WellCommerce\Bundle\CoreBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\VariantAwareTrait;

/**
 * Class OrderProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProduct implements OrderProductInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;
    use ProductAwareTrait;
    use VariantAwareTrait;
    use OrderAwareTrait;
    
    /**
     * @var int
     */
    protected $quantity;
    
    /**
     * @var PriceInterface
     */
    protected $buyPrice;
    
    /**
     * @var PriceInterface
     */
    protected $sellPrice;
    
    /**
     * @var float
     */
    protected $weight;
    
    /**
     * @var array
     */
    protected $options;
    
    /**
     * @var bool
     */
    protected $locked;
    
    public function getCurrentStock() : int
    {
        if ($this->hasVariant()) {
            return $this->getVariant()->getStock();
        }
        
        return $this->getProduct()->getStock();
    }
    
    public function getCurrentSellPrice() : DiscountablePriceInterface
    {
        if ($this->hasVariant()) {
            return $this->getVariant()->getSellPrice();
        }
        
        return $this->getProduct()->getSellPrice();
    }
    
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
    
    public function isLocked(): bool
    {
        return $this->locked;
    }
    
    public function setLocked(bool $locked)
    {
        $this->locked = $locked;
    }
}
