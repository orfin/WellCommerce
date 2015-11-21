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

namespace WellCommerce\CommonBundle\Entity;

/**
 * Class TaxTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait TaxAwareTrait
{
    /**
     * @var TaxInterface
     */
    protected $tax;

    /**
     * @return TaxInterface
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param TaxInterface $tax
     */
    public function setTax(TaxInterface $tax)
    {
        $this->tax = $tax;
    }
}
