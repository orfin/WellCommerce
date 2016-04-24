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

namespace WellCommerce\Bundle\ShippingBundle\Calculator;

/**
 * Interface ShippingSubjectInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingSubjectInterface
{
    public function getQuantity() : int;
    
    public function getWeight() : float;

    public function getNetPrice() : float;

    public function getGrossPrice() : float;

    public function getTaxAmount() : float;

    public function getCurrency() : string;
}
