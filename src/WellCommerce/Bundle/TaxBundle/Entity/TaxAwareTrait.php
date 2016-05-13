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
 * Class TaxTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait TaxAwareTrait
{
    protected $tax;
    
    public function getTax() : TaxInterface
    {
        return $this->tax;
    }
    
    public function setTax(TaxInterface $tax)
    {
        $this->tax = $tax;
    }

    public function hasTax() : bool
    {
        return $this->tax instanceof TaxInterface;
    }
}
