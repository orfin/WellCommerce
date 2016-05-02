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

/**
 * Interface OrderProductTotalInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderProductTotalInterface
{
    public function getQuantity() : int;
    
    public function setQuantity(int $quantity);
    
    public function getWeight() : float;
    
    public function setWeight(float $weight);
    
    public function getNetPrice() : float;
    
    public function setNetPrice(float $netPrice);
    
    public function getGrossPrice() : float;
    
    public function setGrossPrice(float $grossPrice);
    
    public function getTaxAmount() : float;
    
    public function setTaxAmount(float $taxAmount);
}
