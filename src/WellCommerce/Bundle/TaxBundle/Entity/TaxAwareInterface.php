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

namespace WellCommerce\Bundle\TaxBundle\Entity;

/**
 * Interface TaxAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TaxAwareInterface
{
    public function getTax() : TaxInterface;
    
    public function setTax(TaxInterface $tax);

    public function hasTax() : bool;
}
