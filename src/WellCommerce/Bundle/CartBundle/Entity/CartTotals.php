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

namespace WellCommerce\Bundle\CartBundle\Entity;

/**
 * Class CartTotals
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotals implements CartTotalsInterface
{
    /**
     * @var float
     */
    protected $quantity = 0;

    /**
     * @var float
     */
    protected $weight = 0;

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
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * {@inheritdoc}
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

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
        $this->netPrice = (float)$netPrice;
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
        $this->grossPrice = (float)$grossPrice;
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
        $this->taxAmount = (float)$taxAmount;
    }
}
