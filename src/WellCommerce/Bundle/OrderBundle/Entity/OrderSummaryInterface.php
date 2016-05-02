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
 * Interface OrderSummaryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderSummaryInterface
{
    public function getNetAmount() : float;
    
    public function setNetAmount(float $netPrice);
    
    public function getGrossAmount() : float;
    
    public function setGrossAmount(float $grossPrice);
    
    public function getTaxAmount() : float;
    
    public function setTaxAmount(float $taxAmount);
}
