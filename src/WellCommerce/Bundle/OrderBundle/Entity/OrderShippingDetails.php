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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderShippingDetails
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderShippingDetails implements OrderShippingDetailsInterface
{
    /**
     * @var float
     */
    protected $netPrice = 0;

    /**
     * @var float
     */
    protected $grossPrice = 0;

    /**
     * @var float
     */
    protected $taxAmount = 0;

    /**
     * @var float
     */
    protected $taxRate = 0;

    /**
     * {@inheritdoc}
     */
    public function getNetPrice()
    {
        return $this->netPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function setNetPrice($netPrice)
    {
        $this->netPrice = $netPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getGrossPrice()
    {
        return $this->grossPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function setGrossPrice($grossPrice)
    {
        $this->grossPrice = $grossPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * {@inheritdoc}
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;
    }

    /**
     * {@inheritdoc}
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * {@inheritdoc}
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
    }
}
