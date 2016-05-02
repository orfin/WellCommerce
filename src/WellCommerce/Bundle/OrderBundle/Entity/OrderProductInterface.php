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

use WellCommerce\Bundle\AppBundle\Entity\PriceInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
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
    public function getQuantity() : int;
    
    public function setQuantity(int $quantity);
    
    public function increaseQuantity(int $increase);
    
    public function decreaseQuantity(int $decrease);
    
    public function getSellPrice() : PriceInterface;
    
    public function setSellPrice(PriceInterface $sellPrice);
    
    public function getBuyPrice() : PriceInterface;
    
    public function setBuyPrice(PriceInterface $buyPrice);
    
    public function getWeight() : float;
    
    public function setWeight(float $weight);
    
    public function getOptions() : array;
    
    public function setOptions(array $options);
}
