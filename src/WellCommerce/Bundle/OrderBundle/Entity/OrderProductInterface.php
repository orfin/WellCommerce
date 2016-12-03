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

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantAwareInterface;

/**
 * Interface OrderProductInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderProductInterface extends
    EntityInterface,
    ProductAwareInterface,
    VariantAwareInterface,
    TimestampableInterface,
    OrderAwareInterface
{
    public function getQuantity(): int;
    
    public function setQuantity(int $quantity);
    
    public function increaseQuantity(int $increase);
    
    public function decreaseQuantity(int $decrease);
    
    public function getSellPrice(): Price;
    
    public function setSellPrice(Price $sellPrice);
    
    public function getBuyPrice(): Price;
    
    public function setBuyPrice(Price $buyPrice);
    
    public function getWeight(): float;
    
    public function setWeight(float $weight);
    
    public function getOptions(): array;
    
    public function setOptions(array $options);
    
    public function isLocked(): bool;
    
    public function setLocked(bool $locked);
    
    public function getCurrentStock(): int;
    
    public function getCurrentSellPrice(): DiscountablePrice;
}
