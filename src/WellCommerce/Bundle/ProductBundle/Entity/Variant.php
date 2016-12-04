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

namespace WellCommerce\Bundle\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityAwareTrait;
use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\MediaBundle\Entity\MediaAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\Extra\VariantExtraTrait;

/**
 * Class Variant
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Variant implements VariantInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use HierarchyAwareTrait;
    use MediaAwareTrait;
    use AvailabilityAwareTrait;
    use ProductAwareTrait;
    use EnableableTrait;
    use VariantExtraTrait;
    
    protected $weight        = 0.00;
    protected $symbol        = '';
    protected $stock         = 0;
    protected $modifierType  = '%';
    protected $modifierValue = 100.00;
    
    /**
     * @var DiscountablePrice
     */
    protected $sellPrice;
    
    /**
     * @var Collection
     */
    protected $options;
    
    public function __construct()
    {
        $this->sellPrice = new DiscountablePrice();
        $this->options   = new ArrayCollection();
    }
    
    public function getOptions(): Collection
    {
        return $this->options;
    }
    
    public function setOptions(Collection $options)
    {
        if ($this->options instanceof Collection) {
            $this->synchronizeOptions($options);
        }
        
        $this->options = $options;
    }
    
    private function synchronizeOptions(Collection $options)
    {
        $this->options->map(function (VariantOptionInterface $option) use ($options) {
            if (false === $options->contains($option)) {
                $this->options->removeElement($option);
            }
        });
    }
    
    public function getWeight(): float
    {
        return $this->weight;
    }
    
    public function setWeight(float $weight)
    {
        $this->weight = $weight;
    }
    
    public function getSymbol(): string
    {
        return $this->symbol;
    }
    
    public function setSymbol(string $symbol)
    {
        $this->symbol = $symbol;
    }
    
    public function getStock(): int
    {
        return $this->stock;
    }
    
    public function setStock(int $stock)
    {
        $this->stock = $stock;
    }
    
    public function getSellPrice(): DiscountablePrice
    {
        return $this->sellPrice;
    }
    
    public function setSellPrice(DiscountablePrice $sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }
    
    public function getModifierValue(): float
    {
        return $this->modifierValue;
    }
    
    public function setModifierValue(float $modifierValue)
    {
        $this->modifierValue = $modifierValue;
    }
    
    public function getModifierType(): string
    {
        return $this->modifierType;
    }
    
    public function setModifierType(string $modifierType)
    {
        $this->modifierType = $modifierType;
    }
}
